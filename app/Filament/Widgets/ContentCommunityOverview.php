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

    protected ?string $heading = null;

    protected ?string $description = null;

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 1;

    protected function getHeading(): ?string
    {
        return __('admin.content_community');
    }

    protected function getDescription(): ?string
    {
        return __('admin.website_activity_overview');
    }

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
            Stat::make(__('admin.published_articles'), number_format($publishedArticles))
                ->description(__('admin.currently_published'))
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),

            Stat::make(__('admin.published_today'), number_format($articlesPublishedToday))
                ->description(__('admin.articles_published_today'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make(__('admin.verified_users'), number_format($verifiedUsers))
                ->description(__('admin.email_address_verified'))
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make(__('admin.new_registrations'), number_format($newVerifiedUsersThisMonth))
                ->description(__('admin.verified_registrations_this_month'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),

            Stat::make(__('admin.comments_today'), number_format($commentsToday))
                ->description(__('admin.comments_submitted_today'))
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),

            Stat::make(__('admin.pending_reports'), number_format($pendingReports))
                ->description(__('admin.reports_awaiting_review'))
                ->descriptionIcon('heroicon-m-flag')
                ->color($pendingReports > 0 ? 'warning' : 'success'),
        ];
    }
}