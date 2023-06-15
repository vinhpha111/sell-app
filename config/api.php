<?php
return [
    'kiot_barcode_api' => env('KIOT_BARCODE_API', 'https://apisuggest-products.citigo.com.vn/barcode'),
    'icheck_barcode_api' => env('ICHECK_BARCODE_API', 'https://api-social.icheck.com.vn/social/api/products/search'),
    'icheck_tokens' => [
        '7676df7f-8550-41a2-8084-2a238e724678'
    ],
    'google_search_api' => env('GOOGLE_SEARCH_API', 'https://www.googleapis.com/customsearch/v1'),
    'google_search_api_key' => env('GOOGLE_SEARCH_API_KEY', 'AIzaSyD_96fm7DnjnIAagDcDHbeM0ykwFhSe2qY'),
    'google_search_api_cx' => env('GOOGLE_SEARCH_API_CX', '1286d26908561476c'),
];
