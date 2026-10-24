<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserActivityRecorder
{
    public function __construct(
        protected Request $request,
    ) {}

    public function record(User $user, string $activityType): void
    {
        $userAgent = $this->request->userAgent() ?? '';

        $user->loginActivities()->create([
            'activity_type' => $activityType,
            'ip_address' => $this->request->ip(),
            'user_agent' => $userAgent,
            'browser' => $this->getBrowser($userAgent),
            'browser_version' => $this->getBrowserVersion($userAgent),
            'platform' => $this->getPlatform($userAgent),
            'platform_version' => $this->getPlatformVersion($userAgent),
            'device_type' => $this->getDeviceType($userAgent),
            'device' => $this->getDevice($userAgent),
        ]);
    }

    protected function getBrowser(string $userAgent): ?string
    {
        return match (true) {
            Str::contains($userAgent, 'Edg/') => 'Edge',
            Str::contains($userAgent, 'OPR/') => 'Opera',
            Str::contains($userAgent, 'Firefox/') => 'Firefox',
            Str::contains($userAgent, 'Chrome/') => 'Chrome',
            Str::contains($userAgent, 'Safari/') => 'Safari',
            Str::contains($userAgent, ['MSIE', 'Trident/']) => 'Internet Explorer',
            default => null,
        };
    }

    protected function getBrowserVersion(string $userAgent): ?string
    {
        $patterns = [
            'Edg/' => '/Edg\/([\d.]+)/',
            'OPR/' => '/OPR\/([\d.]+)/',
            'Firefox/' => '/Firefox\/([\d.]+)/',
            'Chrome/' => '/Chrome\/([\d.]+)/',
            'Version/' => '/Version\/([\d.]+)/',
            'MSIE' => '/MSIE\s([\d.]+)/',
            'Trident/' => '/rv:([\d.]+)/',
        ];

        foreach ($patterns as $token => $pattern) {
            if (Str::contains($userAgent, $token)
                && preg_match($pattern, $userAgent, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    protected function getPlatform(string $userAgent): ?string
    {
        return match (true) {
            Str::contains($userAgent, 'Windows') => 'Windows',
            Str::contains($userAgent, 'Android') => 'Android',
            Str::contains($userAgent, ['iPhone', 'iPad', 'iPod']) => 'iOS',
            Str::contains($userAgent, ['Macintosh', 'Mac OS']) => 'macOS',
            Str::contains($userAgent, 'CrOS') => 'Chrome OS',
            Str::contains($userAgent, 'Linux') => 'Linux',
            default => null,
        };
    }

    protected function getPlatformVersion(string $userAgent): ?string
    {
        if (preg_match('/Windows NT ([\d.]+)/', $userAgent, $matches)) {
            return match ($matches[1]) {
                '10.0' => '10/11',
                '6.3' => '8.1',
                '6.2' => '8',
                '6.1' => '7',
                default => $matches[1],
            };
        }

        if (preg_match('/Android ([\d.]+)/', $userAgent, $matches)) {
            return $matches[1];
        }

        if (preg_match('/(?:iPhone OS|CPU OS) ([\d_]+)/', $userAgent, $matches)) {
            return str_replace('_', '.', $matches[1]);
        }

        if (preg_match('/Mac OS X ([\d_]+)/', $userAgent, $matches)) {
            return str_replace('_', '.', $matches[1]);
        }

        return null;
    }

    protected function getDeviceType(string $userAgent): string
    {
        if (Str::contains($userAgent, ['iPad', 'Tablet'])) {
            return 'tablet';
        }

        if (
            Str::contains($userAgent, ['Mobile', 'iPhone', 'iPod'])
            || (
                Str::contains($userAgent, 'Android')
                && ! Str::contains($userAgent, 'Tablet')
            )
        ) {
            return 'mobile';
        }

        return 'desktop';
    }

    protected function getDevice(string $userAgent): ?string
    {
        if (Str::contains($userAgent, 'iPhone')) {
            return 'iPhone';
        }

        if (Str::contains($userAgent, 'iPad')) {
            return 'iPad';
        }

        if (Str::contains($userAgent, 'iPod')) {
            return 'iPod';
        }

        if (preg_match('/Android[^;]*;\s*([^;)]+)/', $userAgent, $matches)) {
            return trim($matches[1]);
        }

        if (Str::contains($userAgent, 'Windows')) {
            return 'PC';
        }

        if (Str::contains($userAgent, ['Macintosh', 'Mac OS'])) {
            return 'Mac';
        }

        if (Str::contains($userAgent, 'Linux')) {
            return 'Linux device';
        }

        return null;
    }
}