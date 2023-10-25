<?php

use PHPUnit\Framework\TestCase;
use Framework\Factory\ViewFactory;

class ViewFactoryTest extends TestCase
{
    public function testMakeView()
    {
        $file = fopen(MAIN_DIR."templates/example.php", "w");
        fwrite($file, "Hello {{name}}");
        fclose($file);

        $factory = new ViewFactory("example", ["name" => "John"]);

        $view = $factory->makeView();

        $this->assertEquals("Hello John", $view->html());

        unlink(MAIN_DIR."templates/example.php");
    }
}
