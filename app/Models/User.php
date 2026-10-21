<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
 * @property string $display_name
 * @property string $slug
 * @property string|null $bio
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
    'display_name',
    'slug',
    'bio',
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
class User extends Authenticatable implements PasskeyUser, FilamentUser, HasMedia, HasAvatar
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
            if (blank($user->slug) && filled($user->name)) {
                $user->slug = Str::slug($user->name);
            }
        });

        static::updating(function (User $user) {
            if ($user->isDirty('name') && ! $user->isDirty('slug')) {
                $user->slug = Str::slug($user->name);
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

        if ($this->suspended_until && $this->suspended_until->isPast()) {
            return false;
        }

        return true;
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