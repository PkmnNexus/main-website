<?php

namespace App\Listeners;

use App\Models\User;
use App\Support\UserActivityRecorder;
use Illuminate\Auth\Events\Logout;

class RecordUserLogoutActivity
{
    public function __construct(
        protected UserActivityRecorder $activityRecorder,
    ) {}

    /**
     * Record the user's logout activity.
     */
    public function handle(Logout $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $this->activityRecorder->record($event->user, 'Logout');
    }
}