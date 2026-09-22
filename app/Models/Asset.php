<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

use App\Support\Media\ResponsiveImage;

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
        return $this->belongsTo(
            MediaFolder::class,
            'media_folder_id'
        );
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('asset')
            ->singleFile();
    }

    public function registerMediaConversions(
        ?Media $media = null
    ): void {
        $this->registerImageConversions(
            'thumb',
            300,
            300
        );

        $this->registerImageConversions(
            'card',
            640,
            360
        );

        $this->registerImageConversions(
            'hero',
            1600,
            900
        );

        $this->registerImageConversions(
            'og',
            1200,
            630
        );
    }

    protected function registerImageConversions(
        string $name,
        int $width,
        int $height
    ): void {
        $conversion = $this
            ->addMediaConversion("{$name}-webp")
            ->fit(Fit::Crop, $width, $height)
            ->format('webp')
            ->performOnCollections('asset')
            ->nonQueued();

        if ($name === 'hero') {
            $conversion->withResponsiveImages();
        }

        /*
        $this
            ->addMediaConversion("{$name}-avif")
            ->fit(Fit::Crop, $width, $height)
            ->format('avif')
            ->performOnCollections('asset')
            ->nonQueued();
        */
    }

    public function addResponsiveMedia(string $path): Media
    {
        $media = $this
            ->addMedia($path)
            ->withResponsiveImages()
            ->toMediaCollection('asset');

        $this->syncMediaMetadata();

        return $media;
    }

    public function syncMediaMetadata(): void
    {
        $media = $this->getFirstMedia('asset');

        if (! $media) {
            return;
        }

        $path = $media->getPath();
        $dimensions = @getimagesize($path);

        $this->forceFill([
            'mime_type' => $media->mime_type,
            'file_size' => $media->size,
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
        ])->saveQuietly();
    }

    public function responsiveImage(
        string $conversion = 'hero-webp'
    ): ?ResponsiveImage {
        $media = $this->getFirstMedia('asset');

        if (! $media) {
            return null;
        }

        return new ResponsiveImage(
            $media,
            $conversion,
        );
    }
}