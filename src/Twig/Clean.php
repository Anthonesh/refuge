<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('clean_input', [$this, 'cleanInput']),
        ];
    }

    public function cleanInput(string $string): string
    {
        return htmlspecialchars(strip_tags(trim($string)));
    }
}