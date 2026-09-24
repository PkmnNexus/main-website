<?php

namespace App\View\Components\Pages;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class TagList extends Component
{
    public Collection $tags;

    public function __construct(?Collection $tags = null)
    {
        $this->tags = $tags ?? collect();
    }

    public function name($tag): string
    {
        $name = $tag->name;

        if (is_string($name) && str_contains($name, '{')) {
            $decoded = json_decode($name, true);

            if (is_array($decoded)) {
                $name = $decoded['en'] ?? reset($decoded);
            }
        }

        if (is_array($name)) {
            $name = $name['en'] ?? reset($name);
        }

        return (string) $name;
    }

    public function slug($tag): string
    {
        return $tag->slug ?? Str::slug($this->name($tag));
    }

    public function render(): View|Closure|string
    {
        return view('components.pages.tag-list');
    }
}