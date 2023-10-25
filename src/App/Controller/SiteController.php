<?php

namespace App\Controller;

use App\Model\Contact;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class SiteController {
    public function __construct()
    {
        
    }

    public static function showHome() {
        return Page::get()->loadTemplate("site.home", ["title"=>"Heeey"]);
    }
}