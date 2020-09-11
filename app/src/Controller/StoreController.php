<?php

namespace App\Controller;

use App\DataProvider\ItemListGenerator;
use App\Output\StoreOutput;
use App\ViewTransformer\StoreTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreController
{
    private ItemListGenerator $itemListGenerator;
    private StoreOutput $storeOutput;
    private StoreTransformer $storeTransformer;

    public function __construct(
        ItemListGenerator $itemListGenerator,
        StoreTransformer $storeTransformer,
        StoreOutput $storeOutput
    ) {
        $this->itemListGenerator = $itemListGenerator;
        $this->storeTransformer = $storeTransformer;
        $this->storeOutput = $storeOutput;
    }

    public function getStore(Request $request): Response
    {
        $storeId = $request->attributes->get('id')
            ? (int) $request->attributes->get('id')
            : rand(1, 100000);

        $storeModel = $this->storeTransformer->transform(
            $storeId,
            'General store',
            $this->itemListGenerator->generate($storeId)
        );

        return $this->storeOutput->output($request, $storeModel);
    }
}
