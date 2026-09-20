<?php

namespace App\Filament\Forms\Components\Media\Browser;

use App\Models\Asset;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final readonly class AssetBrowser
{
    public function __construct(
        protected AssetBrowserFilters $filters,
    ) {}

    public function query(): Builder
    {
        return Asset::query()
            ->with([
                'folder',
                'media',
            ])
            ->when(
                $this->filters->folderId,
                fn (Builder $query) => $query->where(
                    'media_folder_id',
                    $this->filters->folderId,
                ),
            )
            ->when(
                $this->filters->search,
                function (Builder $query) {
                    $search = $this->filters->search;

                    $query->where(function (Builder $query) use ($search) {
                        $query
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('alt', 'like', "%{$search}%")
                            ->orWhere('caption', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('photographer', 'like', "%{$search}%")
                            ->orWhere('copyright', 'like', "%{$search}%");
                    });
                },
            )
            ->when(
                $this->filters->mimeType,
                fn (Builder $query) => $query->where(
                    'mime_type',
                    $this->filters->mimeType,
                ),
            )
            ->orderBy(
                $this->filters->sort,
                $this->filters->direction,
            );
    }

    public function get(): Collection
    {
        return $this->query()
            ->get()
            ->map(
                fn (Asset $asset) => AssetBrowserResult::fromAsset($asset)
            );
    }

    public function paginate(): LengthAwarePaginator
    {
        return $this->query()->paginate(
            $this->filters->perPage,
        );
    }
}