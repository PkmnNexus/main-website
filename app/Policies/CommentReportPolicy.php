<?php

namespace App\Policies;

use App\Models\CommentReport;
use App\Models\User;

class CommentReportPolicy
{
    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user may view the reports overview.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user may view a report.
     */
    public function view(User $user, CommentReport $commentReport): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Reports may only be submitted through the public reporting form.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user may moderate a report.
     */
    public function update(User $user, CommentReport $commentReport): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Reports cannot be deleted through the admin panel.
     */
    public function delete(User $user, CommentReport $commentReport): bool
    {
        return false;
    }

    /**
     * Reports cannot be restored through the admin panel.
     */
    public function restore(User $user, CommentReport $commentReport): bool
    {
        return false;
    }

    /**
     * Reports cannot be permanently deleted through the admin panel.
     */
    public function forceDelete(User $user, CommentReport $commentReport): bool
    {
        return false;
    }
}