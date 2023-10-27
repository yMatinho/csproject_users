<?php

namespace Framework\Response;

use Framework\Model\Model;

abstract class JsonResource {
    abstract public function exportFromArray(array $data): array;
    public function exportFromModel(Model $model): array {
        return $this->exportFromArray($model->toArray());
    }
}