<?php

namespace App\Filament\Resources\CommentReports\Pages;

use App\Filament\Resources\CommentReports\CommentReportResource;
use Filament\Resources\Pages\ListRecords;

class ListCommentReports extends ListRecords
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static string $resource = CommentReportResource::class;
}
