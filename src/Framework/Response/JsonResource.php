<?php

namespace Framework\Response;

interface JsonResource {
    public function exportFromArray(array $data): array;
}