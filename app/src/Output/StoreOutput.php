<?php

namespace App\Output;

use App\ViewModel\StoreModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoreOutput
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function output(Request $request, StoreModel $store): Response
    {
        return new JsonResponse($store->asArray());
    }
}
