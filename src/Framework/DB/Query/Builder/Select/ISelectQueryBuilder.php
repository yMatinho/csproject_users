<?php

namespace Framework\DB\Query\Builder\Select;

interface ISelectQueryBuilder {
    public function partInitial(): string;
    public function partClausures(): string;
    public function partOrderBy($orderBy="", $orderByOrder=""): string;
    public function partLimit($limit=0): string;
}