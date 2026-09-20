<?php

namespace App\Services;

use App\Models\MediaFolder;
use Illuminate\Support\Collection;

class MediaBreadcrumbService
{
    public function make(?int $folderId): Collection
    {
        $breadcrumbs = collect([
            [
                'id' => null,
                'name' => 'Alle assets',
            ],
        ]);

        if (! $folderId) {
            return $breadcrumbs;
        }

        $folder = MediaFolder::with('parent')->find($folderId);

        if (! $folder) {
            return $breadcrumbs;
        }

        $parents = collect();

        while ($folder) {
            $parents->prepend([
                'id' => $folder->id,
                'name' => $folder->name,
            ]);

            $folder = $folder->parent;
        }

        return $breadcrumbs->merge($parents);
    }
}