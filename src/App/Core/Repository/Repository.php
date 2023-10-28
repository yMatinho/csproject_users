<?php

namespace App\Core\Repository;

use Framework\Model\Collection;
use Framework\Model\Model;

interface Repository {
    public function findAll(): Collection;
    public function findById(int|string $id, bool $throwNotFoundException = false): Model;
    public function create(object $dto): Model;
    public function update(Model $model, object $dto): Model;
    public function delete(Model $model): bool;
}
