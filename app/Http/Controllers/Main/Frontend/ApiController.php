<?php

namespace App\Http\Controllers\Main\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scandinaver\Common\Domain\Services\ApiService;
use Validator;

/**
 * Created by PhpStorm.
 * User: whiskey
 * Date: 19.02.15
 * Time: 23:08
 *
 * Class ApiController
 * @package App\Http\Controllers\Main\Frontend
 *
 */
class ApiController extends Controller
{
    /**
     * @var ApiService
     */
    protected $apiService;

    /**
     * ApiController constructor.
     * @param ApiService $apiService
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @return JsonResponse
     */
    public function languages()
    {
        $languages = $this->apiService->getLanguagesList();

        return response()->json($languages);
    }

    /**
     * @param $language
     * @return JsonResponse
     * @throws \Exception
     */
    public function assets($language)
    {
        $validator = Validator::make(['language' => $language], [
            'language' => 'exists:Scandinaver\Common\Domain\Language,name'
        ], [
            'exist' => 'Неверный параметр'
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $assets = $this->apiService->getAssets($language);

        return response()->json($assets);
    }
} 