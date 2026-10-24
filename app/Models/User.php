<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
use Filament\Models\Contracts\HasAvatar;

/**
 * @property int $id
 * @property string $name
 * @property string|null $surname
 * @property string $display_name
 * @property string|null $flair
 * @property string $slug
 * @property string|null $bio
 * @property string|null $location
 * @property string|null $website
 * @property string|null $social_link_1
 * @property string|null $social_link_2
 * @property string|null $social_link_3
 * @property string|null $social_link_4
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property Carbon|null $last_login_at
 * @property Carbon|null $last_activity_at
 * @property Carbon|null $suspended_at
 * @property Carbon|null $suspended_until
 * @property string|null $suspended_reason
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'name',
    'surname',
    'display_name',
    'flair',
    'slug',
    'bio',
    'location',
    'website',
    'social_link_1',
    'social_link_2',
    'social_link_3',
    'social_link_4',
    'email',
    'password',
    'is_active',
    'last_login_at',
    'last_activity_at',
    'suspended_at',
    'suspended_until',
    'suspended_reason',
])]
#[Hidden([
    'password',
    'two_factor_secret',
    'two_factor_recovery_codes',
    'remember_token',
])]
class User extends Authenticatable implements MustVerifyEmail, PasskeyUser, FilamentUser, HasMedia, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable, HasRoles, InteractsWithMedia;

    /*
    |--------------------------------------------------------------------------
    | Booted
    |--------------------------------------------------------------------------
    */

    /**
     * Configure model events.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (blank($user->slug) && filled($user->display_name)) {
                $user->slug = Str::slug($user->display_name);
            }
        });

        static::updating(function (User $user) {
            if ($user->isDirty('display_name') && ! $user->isDirty('slug')) {
                $user->slug = Str::slug($user->display_name);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Relationships that should always be loaded.
     */
    protected $with = [];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'suspended_at' => 'datetime',
            'suspended_until' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope the query to active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the articles created by the user.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get all non-deleted comments written by the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all activities recorded for the user.
     */
    public function loginActivities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    /**
     * Get the user's Filament avatar URL.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        $media = $this->getFirstMedia('user_avatar');

        if (! $media) {
            return null;
        }

        return $media->getUrl('avatar-webp');
    }

    /**
     * Determine whether the user is currently suspended.
     */
    public function isSuspended(): bool
    {
        if (! $this->suspended_at) {
            return false;
        }

        return ! $this->suspended_until
            || $this->suspended_until->isFuture();
    }

    /**
     * Determine whether the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() !== 'admin') {
            return false;
        }

        return $this->is_active
            && ! $this->isSuspended()
            && $this->hasAnyRole(['author', 'editor', 'admin']);
    }

    /**
     * Get the formatted website URL for display.
     */
    public function getFormattedWebsiteAttribute(): ?string
    {
        if (blank($this->website)) {
            return null;
        }

        $host = parse_url($this->website, PHP_URL_HOST);

        if (blank($host)) {
            return null;
        }

        return 'www.'.preg_replace('/^www\./i', '', $host);
    }

    /**
     * Get the user's social media links with their platform information.
     */
    public function getSocialLinksAttribute(): array
    {
        return collect([
            $this->social_link_1,
            $this->social_link_2,
            $this->social_link_3,
            $this->social_link_4,
        ])
            ->filter(fn (?string $url) => filled($url))
            ->map(function (string $url): array {
                $platform = $this->getSocialPlatform($url);

                return [
                    'url' => $url,
                    'platform' => $platform['name'],
                    'icon' => $platform['icon'],
                ];
            })
            ->values()
            ->all();
    }

    /**
     * Identify a social media platform from its URL.
     */
    public function getSocialPlatform(string $url): array
    {
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $host = preg_replace('/^www\./i', '', $host);

        $platforms = [
            'facebook.com' => ['name' => 'Facebook', 'icon' => 'icon.facebook'],
            'instagram.com' => ['name' => 'Instagram', 'icon' => 'icon.instagram'],
            'youtube.com' => ['name' => 'YouTube', 'icon' => 'icon.youtube'],
            'youtu.be' => ['name' => 'YouTube', 'icon' => 'icon.youtube'],
            'x.com' => ['name' => 'X', 'icon' => 'icon.x'],
            'twitter.com' => ['name' => 'X', 'icon' => 'icon.x'],
            'tiktok.com' => ['name' => 'TikTok', 'icon' => 'icon.tiktok'],
            'linkedin.com' => ['name' => 'LinkedIn', 'icon' => 'icon.linkedin'],
            'twitch.tv' => ['name' => 'Twitch', 'icon' => 'icon.twitch'],
            'pinterest.com' => ['name' => 'Pinterest', 'icon' => 'icon.pinterest'],
            'reddit.com' => ['name' => 'Reddit', 'icon' => 'icon.reddit'],
            'threads.net' => ['name' => 'Threads', 'icon' => 'icon.threads'],
            'bsky.app' => ['name' => 'Bluesky', 'icon' => 'icon.bluesky'],
        ];

        foreach ($platforms as $domain => $platform) {
            if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                return $platform;
            }
        }

        return [
            'name' => 'Website',
            'icon' => 'website',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Media Collections
    |--------------------------------------------------------------------------
    */

    /**
     * Register the user's media collections.
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('user_avatar')
            ->singleFile();
    }

    /*
    |--------------------------------------------------------------------------
    | Media Conversions
    |--------------------------------------------------------------------------
    */

    /**
     * Register the user's media conversions.
     */
    public function registerMediaConversions(
        ?Media $media = null
    ): void {
        $this
            ->addMediaConversion('avatar-webp')
            ->fit(Fit::Crop, 250, 250)
            ->format('webp')
            ->performOnCollections('user_avatar')
            ->nonQueued();
    }
}