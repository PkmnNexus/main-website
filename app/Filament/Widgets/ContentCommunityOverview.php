<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentReport;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentCommunityOverview extends BaseWidget
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected ?string $heading = 'Content & Community';

    protected ?string $description = 'An overview of your website activity.';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 1;

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    /**
     * Get the main content and community statistics.
     *
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $today = now()->toDateString();

        $startOfMonth = now()->startOfMonth();

        $publishedArticles = Article::query()
            ->published()
            ->count();

        $articlesPublishedToday = Article::query()
            ->published()
            ->whereDate('published_at', $today)
            ->count();

        $verifiedUsers = User::query()
            ->whereNotNull('email_verified_at')
            ->count();

        $newVerifiedUsersThisMonth = User::query()
            ->whereNotNull('email_verified_at')
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        $commentsToday = Comment::query()
            ->whereDate('created_at', $today)
            ->count();

        $pendingReports = CommentReport::query()
            ->where('status', CommentReport::STATUS_PENDING)
            ->count();

        return [
            Stat::make('Published articles', number_format($publishedArticles))
                ->description('Currently published')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),

            Stat::make('Published today', number_format($articlesPublishedToday))
                ->description('Articles published today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Verified users', number_format($verifiedUsers))
                ->description('Email address verified')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('New registrations', number_format($newVerifiedUsersThisMonth))
                ->description('Verified registrations this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),

            Stat::make('Comments today', number_format($commentsToday))
                ->description('Comments submitted today')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),

            Stat::make('Pending reports', number_format($pendingReports))
                ->description('Reports awaiting review')
                ->descriptionIcon('heroicon-m-flag')
                ->color($pendingReports > 0 ? 'warning' : 'success'),
        ];
    }
}