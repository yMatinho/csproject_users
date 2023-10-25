<?php

namespace Framework\Singleton;

interface Singleton {
    public static function get():Singleton;
}