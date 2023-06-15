<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;

class BarcodeService {
    public function getProductInfoByBarcode($barcode) {
        $products = $this->getInfoFromKiot($barcode);
        if ($products && count($products['results']) > 0) {
            return $products;
        }

        $products = $this->getInfoFromIcheck($barcode);
        if ($products && count($products['results']) > 0) {
            return $products;
        }

        $products = $this->getInfoFromGoogle($barcode);
        if ($products && count($products['results']) > 0) {
            return $products;
        }

        return null;
    }

    public function getInfoFromKiot($barcode)
    {
        $response = Http::get(config('api.kiot_barcode_api'), [
            'query' => $barcode
        ]);
        $data = $response->json();
        if ($response->status() === 200 && count($data['results']) > 0) {
            $data['type'] = "KIOT";
            return $data;
        }
        return null;
    }

    public function getInfoFromIcheck($barcode)
    {
        foreach (config('api.icheck_tokens') as $token) {
            $response = Http::withToken($token)->get(config('api.icheck_barcode_api'), [
                'nameCode' => $barcode,
                'limit' => 10,
                'offset' => 0
            ]);
            if ($response->status() === 200) {
                $data = $response->json();
                if ($data['data']['count'] > 0) {
                    return [
                        'type' => 'ICHECK',
                        'results' => $data['data']['rows']
                    ];
                }
                return null;
            }
        }
        return null;
    }

    public function getInfoFromGoogle($barcode)
    {
        $response = Http::get(config('api.google_search_api'), [
            'key' => config('api.google_search_api_key'),
            'cx' => config('api.google_search_api_cx'),
            'q' => $barcode,
            'searchType' => 'image'
        ]);
        $data = $response->json();
        if ($response->status() === 200 && (int)$data['searchInformation']['totalResults'] > 0) {
            return [
                'type' => 'GOOGLE',
                'results' => $data['items']
            ];
        }
        return null;
    }
}