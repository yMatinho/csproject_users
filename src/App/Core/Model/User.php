<?php

namespace App\Core\Model;

use Framework\Model\Model;
use Framework\DB\Table\Table;

class User extends Model {
    protected static Table $table;
    public function __construct()
    {
        parent::__construct();
    }

    public static function init():void {
        static::$table = new Table("users", ["username", "first_name", "last_name", "email", "password", "created_at", "updated_at"]);
    }
}

User::init();