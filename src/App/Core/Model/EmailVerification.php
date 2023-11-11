<?php

namespace App\Core\Model;

use Framework\Model\Model;
use Framework\DB\Table\Table;

class EmailVerification extends Model
{
    protected static Table $table;
    public function __construct()
    {
        parent::__construct();
    }

    public function getUser(): User {
        return $this->user ?: User::find($this->user_id);
    }
    
    public static function init(): void
    {
        static::$table = new Table("email_verifications", [
            "user_id", "token", "accepted_at", "created_at", "updated_at"
        ]);
    }
}

EmailVerification::init();
