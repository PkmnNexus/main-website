<?php

namespace App\Listeners;

use App\Support\UserActivityRecorder;
use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    public function __construct(
        protected UserActivityRecorder $activityRecorder,
    ) {}

    /**
     * Update the user's last login timestamp and record the login activity.
     */
    public function handle(Login $event): void
    {
        $event->user->forceFill([
            'last_login_at' => now(),
        ])->save();

        $this->activityRecorder->record($event->user, 'Login');
    }
}