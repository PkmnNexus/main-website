<?php

namespace App\Filament\Resources\CommentReports;

use App\Filament\Resources\CommentReports\Pages\ListCommentReports;
use App\Filament\Resources\CommentReports\Pages\ViewCommentReport;
use App\Filament\Resources\CommentReports\Schemas\CommentReportInfolist;
use App\Filament\Resources\CommentReports\Tables\CommentReportsTable;
use App\Models\CommentReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class CommentReportResource extends Resource
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?string $model = CommentReport::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static string|UnitEnum|null $navigationGroup = 'Comments';

    protected static ?string $navigationLabel = 'Reports';

    protected static ?int $navigationSort = -1;

    protected static ?string $modelLabel = 'report';

    protected static ?string $pluralModelLabel = 'reports';

    protected static ?string $recordTitleAttribute = 'reason';

    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

    /**
     * Only users authorized by the policy may access comment reports.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', CommentReport::class) ?? false;
    }

    /*
    |--------------------------------------------------------------------------
    | Schemas
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the report details.
     */
    public static function infolist(Schema $schema): Schema
    {
        return CommentReportInfolist::configure($schema);
    }

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the comment reports table.
     */
    public static function table(Table $table): Table
    {
        return CommentReportsTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    /**
     * Eager load related records used by the reports table and detail page.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'comment.article',
                'reporter',
                'reviewer',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    /**
     * Reports can be listed and viewed, but not created or deleted manually.
     */
    public static function getPages(): array
    {
        return [
            'index' => ListCommentReports::route('/'),
            'view' => ViewCommentReport::route('/{record}'),
        ];
    }
}