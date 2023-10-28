<?php

namespace Framework\Model;

class Collection {
    public function __construct(protected array $models=[]) {}

    public function getModels(): array {
        return $this->models;
    }

    public function addModel(Model $model) {
        $this->models[] = $model;
    }

    public function toArray(): array {
        $finalArray = [];
        foreach($this->getModels() as $model) {
            $finalArray[] = $model->toArray();
        }

        return $finalArray;
    }
}