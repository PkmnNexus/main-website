<?php

namespace App\Listeners;

use App\Models\Asset;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class SyncAssetMetadata
{
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if (! $media->model instanceof Asset) {
            return;
        }

        $path = $media->getPath();

        if (! file_exists($path)) {
            return;
        }

        [$width, $height] = getimagesize($path);

        $media->model->update([
            'width' => $width,
            'height' => $height,
            'file_size' => $media->size,
            'mime_type' => $media->mime_type,
            'extension' => pathinfo($media->file_name, PATHINFO_EXTENSION),
        ]);
    }
}