<?php

namespace App\Services;

use App\Models\MediaFolder;
use Illuminate\Database\Eloquent\Collection;

class MediaFolderService
{
    public function tree(): Collection
    {
        return MediaFolder::query()
            ->roots()
            ->withCount('assets')
            ->with([
                'children' => fn ($query) => $query
                    ->withCount('assets')
                    ->orderBy('sort_order')
                    ->orderBy('name'),
            ])
            ->get();
    }
}