<?php

use Framework\Singleton\Page\Page;
use Framework\View\View;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testLoadTemplate()
    {
        $file = fopen(MAIN_DIR."templates/example.php", "w");
        fwrite($file, "Hello, my name is {{name}} and I am {{age}} years old.");
        fclose($file);

        $page = Page::get();
        $template = 'example';
        $replacements = ['name' => 'John', 'age' => 25];
        $expectedOutput = 'Hello, my name is John and I am 25 years old.';

        
        $this->assertEquals($expectedOutput, $page->loadTemplate($template, $replacements));
        unlink(MAIN_DIR."templates/example.php");
    }
    public function testGetView()
    {
        $file = fopen(MAIN_DIR."templates/example.php", "w");
        fwrite($file, "Hello, my name is {{name}} and I am {{age}} years old.");
        fclose($file);

        $page = Page::get();
        $template = 'example';
        $replacements = ['name' => 'John', 'age' => 25];

        $this->assertInstanceOf(View::class, $page->getView($template, $replacements));
        unlink(MAIN_DIR."templates/example.php");
    }
}
