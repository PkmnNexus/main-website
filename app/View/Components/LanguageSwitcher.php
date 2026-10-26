<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    public array $locales;

    public string $currentLocale;

    public array $currentLanguage;

    public function __construct()
    {
        $this->locales = config('localization.locales', []);

        foreach ($this->locales as $locale => $language) {
            $this->locales[$locale]['icon'] = 'flag-country-'
                . $language['flag'];
        }

        $defaultLocale = config('localization.default', 'en');

        $this->currentLocale = app()->getLocale();

        if (! isset($this->locales[$this->currentLocale])) {
            $this->currentLocale = $defaultLocale;
        }

        $this->currentLanguage = $this->locales[$this->currentLocale]
            ?? reset($this->locales)
            ?: [];
    }

    public function isEnabled(): bool
    {
        return (bool) config('localization.enabled', false)
            && count($this->locales) > 1;
    }

    public function render(): View
    {
        return view('components.language-switcher');
    }
}