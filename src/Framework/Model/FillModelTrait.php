<?php

namespace Framework\Model;

use Framework\DB\Table\Table;

trait FillModelTrait {
    protected function fillModel(Model $model, Table $table, array $data): Model {
        foreach($table->getCollumns() as $collumn) {
            $model->$collumn = $data[$collumn];
        }

        return $model;
    }
}