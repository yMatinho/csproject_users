<?php

namespace Framework\Response;

use Framework\Model\Collection;
use Framework\Model\Model;

abstract class JsonResource {
    abstract public function exportFromArray(array $data): array;
    public function exportFromModel(Model $model): array {
        return $this->exportFromArray($model->toArray());
    }

    public function exportFromCollection(Collection $collection): array {
        $finalArray = [];
        foreach($collection->getModels() as $model) {
            $finalArray[] = $this->exportFromModel($model);
        }

        return $finalArray;
    }
}