<?php

namespace App\Model;

use Framework\Model\Model;
use Framework\DB\Table\Table;

class Product extends Model {
    public function __construct()
    {
        parent::__construct();
    }

    public static function init():void {
        self::$table = new Table("products", ["title", "price", "description"]);
    }
}

Product::init();