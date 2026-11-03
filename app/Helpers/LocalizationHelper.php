<?php

use Carbon\Carbon;

if (! function_exists('localized_route')) {
    function localized_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        if (! config('localization.enabled', false)) {
            return route($name, $parameters, $absolute);
        }

        $locale = app()->getLocale();
        $defaultLocale = config('localization.default', 'en');

        $routeName = $locale === $defaultLocale
            ? $name
            : $name . '.' . $locale;

        return route($routeName, $parameters, $absolute);
    }
}

if (! function_exists('localized_date')) {
    function localized_date(
        DateTimeInterface|string|null $date,
        string $dateType = 'long',
        string $timeType = 'short',
        bool $showTime = true,
    ): ?string {
        if ($date === null || $date === '') {
            return null;
        }

        $locale = app()->getLocale();

        $formatterLocale = config(
            "localization.locales.{$locale}.format",
            $locale,
        );

        $timezone = config('app.timezone', 'UTC');

        $date = $date instanceof DateTimeInterface
            ? Carbon::instance($date)
            : Carbon::parse($date, $timezone);

        $date = $date->setTimezone($timezone);

        if ($formatterLocale === 'en_US') {
            $formattedDate = $date->format('F jS - Y');

            if ($showTime) {
                $formattedDate .= ', ' . $date->format('g:i A');
            }

            return $formattedDate;
        }

        $pattern = $showTime
            ? 'd MMMM yyyy \'om\' HH:mm'
            : 'd MMMM yyyy';

        $formatter = new IntlDateFormatter(
            $formatterLocale,
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            $timezone,
        );

        $formatter->setPattern($pattern);

        $formattedDate = $formatter->format($date->getTimestamp());

        return $formattedDate === false ? null : $formattedDate;
    }
}