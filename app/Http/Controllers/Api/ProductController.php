<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\BarcodeService;
use App\Http\Resources\Barcode\KiotResource;
use App\Http\Resources\Barcode\IcheckResource;
use App\Http\Resources\Barcode\GoogleResource;

class ProductController extends Controller
{
    private $barcodeService;
    const PRODUCT_RESOURCE_BY_TYPE = [
        'KIOT' => KiotResource::class,
        'ICHECK' => IcheckResource::class,
        'GOOGLE' => GoogleResource::class,
    ];

    public function __construct(BarcodeService $barcodeService) {
        $this->barcodeService = $barcodeService;
    }
    public function getProductInfoByBarcode(Request $request)
    {
        $product = $this->barcodeService->getProductInfoByBarcode($request->barcode);

        return response()->json([
            'items' => $product ? (self::PRODUCT_RESOURCE_BY_TYPE[$product['type']])::collection($product['results']) : null
        ]);
    }
}
