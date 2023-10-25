<?php

namespace Framework\View;

class View {
    private string $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    public function html(): string {
        return $this->html;
    }
}