<?php

namespace Framework\Factory;

use Framework\Singleton\Page\Page;
use Framework\View\View;

const TEMPLATE_NAMES = 1;
const TEMPLATE_REPLACEMENTS = 2;

class ViewFactory
{
    private string $template;
    private array $replacements;

    public function __construct(string $template, array $replacements)
    {
        $this->template = $template;
        $this->replacements = $replacements;
    }

    public function makeView(): View
    {
        ob_start();
        include MAIN_DIR . "templates/" . str_replace(".", "/", $this->template) . ".php";
        $templateContents = ob_get_clean();
        $this->replace($templateContents);
        $this->parseIncludes($templateContents);

        return new View($templateContents);
    }

    private function parseIncludes(&$templateContents): void
    {
        $allIncludes = [];
        preg_match_all("/@include\(['\"](.*?)['\"](?:,(.*?))\)/", $templateContents, $allIncludes);
        if (!$this->hasIncludesToParse($allIncludes))
                return;
        foreach ($allIncludes[TEMPLATE_NAMES] as $key => $templateName)
            $this->replaceIncludes($allIncludes, $templateContents, $key);
    }

    private function hasIncludesToParse($allIncludes): bool
    {
        if (empty($allIncludes[0]))
            return false;
        return true;
    }

    private function replaceIncludes($allIncludes, &$templateContents, $key): void
    {
        $templateContents = str_replace(
            [
                "@include('" . $allIncludes[TEMPLATE_NAMES][$key] . "'," . (string)$allIncludes[TEMPLATE_REPLACEMENTS][$key] . ")",
                "@include(\"" . $allIncludes[TEMPLATE_NAMES][$key] . "\"," . (string)$allIncludes[TEMPLATE_REPLACEMENTS][$key] . ")",
                "@include('" . $allIncludes[TEMPLATE_NAMES][$key] . "', " . (string)$allIncludes[TEMPLATE_REPLACEMENTS][$key] . ")",
                "@include(\"" . $allIncludes[TEMPLATE_NAMES][$key] . "\", " . (string)$allIncludes[TEMPLATE_REPLACEMENTS][$key] . ")",
            ],
            Page::get()->loadTemplate($allIncludes[TEMPLATE_NAMES][$key], eval("return ".$allIncludes[TEMPLATE_REPLACEMENTS][$key].";")),
            $templateContents
        );
    }

    private function replace(&$templateContents): void
    {
        foreach ($this->replacements as $replacementLabel => $replacement) {
            $templateContents = str_replace('{{' . $replacementLabel . '}}', $replacement, $templateContents);
            $templateContents = str_replace("{{ $replacementLabel }}", $replacement, $templateContents);
        }
    }
}
