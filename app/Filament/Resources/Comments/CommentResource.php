<?php

namespace App\Filament\Resources\Comments;

use App\Filament\Resources\Comments\Pages\EditComment;
use App\Filament\Resources\Comments\Pages\ListComments;
use App\Filament\Resources\Comments\Schemas\CommentForm;
use App\Filament\Resources\Comments\Tables\CommentsTable;
use App\Models\Comment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CommentResource extends Resource
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?string $model = Comment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = -2;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.comments');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.comments');
    }

    public static function getModelLabel(): string
    {
        return __('admin.comment');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.comments');
    }

    public static function getBreadcrumb(): string
    {
        return static::getNavigationLabel();
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

    /**
     * Only administrators and editors may access comment moderation.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    /*
    |--------------------------------------------------------------------------
    | Record Titles
    |--------------------------------------------------------------------------
    */

    /**
     * Generate a concise, recognizable title for a comment record.
     */
    public static function getRecordTitle(?\Illuminate\Database\Eloquent\Model $record): ?string
    {
        if (! $record instanceof Comment) {
            return null;
        }

        $username = $record->user?->display_name ?? __('admin.guest');

        return __('admin.comment_record_title', [
            'id' => $record->getKey(),
            'username' => $username,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Schemas
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the comment edit form.
     */
    public static function form(Schema $schema): Schema
    {
        return CommentForm::configure($schema);
    }

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the comments table.
     */
    public static function table(Table $table): Table
    {
        return CommentsTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    /**
     * Include soft-deleted comments so moderators can inspect and restore them.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * Allow edit-page route binding to find soft-deleted comments as well.
     */
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    /**
     * Comments can be listed and edited, but not created through the admin.
     */
    public static function getPages(): array
    {
        return [
            'index' => ListComments::route('/'),
            'edit' => EditComment::route('/{record}/edit'),
        ];
    }
}