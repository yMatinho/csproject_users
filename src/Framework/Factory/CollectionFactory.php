<?php

namespace Framework\Factory;

use Framework\Controller\Controller;
use Framework\Model\Collection;
use Framework\Model\Model;
use Framework\Singleton\Page\Page;
use Framework\View\View;

class CollectionFactory
{
    public function __construct()
    {
    }

    public function makeFromQueryResults(array $queryResults, string $staticModelClass): Collection
    {
        $collection = new Collection();
        foreach($queryResults as $result) {
            $collection->addModel($staticModelClass::fromData($result));
        }

        return $collection;
    }
}
