<?php

namespace Framework\DB\Query\Builder\Select;

class SelectQueryDirector
{
    private ISelectQueryBuilder $builder;
    private string $orderBy;
    private string $orderByOrder;
    private string $limit;
    public function __construct(ISelectQueryBuilder $builder, string $orderBy="", string $orderByOrder="", string $limit="")
    {
        $this->builder = $builder;
        $this->orderBy = $orderBy;
        $this->orderByOrder = $orderByOrder;
        $this->limit = $limit;
    }

    public function makeQuery(): string {
        $query = $this->builder->partInitial();
        $query.=$this->builder->partClausures();
        $query.=$this->builder->partOrderBy($this->orderBy, $this->orderByOrder);
        $query.=$this->builder->partLimit($this->limit);

        return $query;
    }
}
