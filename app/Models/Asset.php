<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Asset extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'media_folder_id',
        'title',
        'alt',
        'caption',
        'description',
        'photographer',
        'copyright',
        'mime_type',
        'file_size',
        'width',
        'height',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class, 'media_folder_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('asset')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 300)
            ->performOnCollections('asset')
            ->nonQueued();

        $this
            ->addMediaConversion('card')
            ->fit(Fit::Crop, 640, 360)
            ->performOnCollections('asset')
            ->nonQueued();

        $this
            ->addMediaConversion('hero')
            ->fit(Fit::Crop, 1600, 900)
            ->performOnCollections('asset')
            ->nonQueued();

        $this
            ->addMediaConversion('og')
            ->fit(Fit::Crop, 1200, 630)
            ->performOnCollections('asset')
            ->nonQueued();
    }

    public function syncMediaMetadata(): void
    {
        $media = $this->getFirstMedia('asset');

        if (! $media) {
            return;
        }

        [$width, $height] = getimagesize($media->getPath());

        $this->forceFill([
            'mime_type' => $media->mime_type,
            'extension' => pathinfo($media->file_name, PATHINFO_EXTENSION),
            'file_size' => $media->size,
            'width' => $width,
            'height' => $height,
        ])->saveQuietly();
    }
}