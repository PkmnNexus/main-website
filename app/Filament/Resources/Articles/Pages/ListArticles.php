<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('admin.all')),

            'draft' => Tab::make()
                ->label(__('admin.drafts'))
                ->badge(fn () => $this->getModel()::where('status', ArticleStatus::Draft)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ArticleStatus::Draft)),

            'pending' => Tab::make()
                ->label(__('admin.pending'))
                ->badge(fn () => $this->getModel()::where('status', ArticleStatus::Pending)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ArticleStatus::Pending)),

            'published' => Tab::make()
                ->label(__('admin.published'))
                ->badge(fn () => $this->getModel()::where('status', ArticleStatus::Published)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ArticleStatus::Published)),

            'archived' => Tab::make()
                ->label(__('admin.archived'))
                ->badge(fn () => $this->getModel()::where('status', ArticleStatus::Archived)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ArticleStatus::Archived)),
        ];
    }
}