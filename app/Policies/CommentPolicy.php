<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user may manage comments.
     */
    protected function canManageComments(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the comment belongs to the authenticated user.
     */
    protected function isOwnComment(User $user, Comment $comment): bool
    {
        return $comment->user_id !== null
            && (int) $comment->user_id === (int) $user->getKey();
    }

    /*
    |--------------------------------------------------------------------------
    | Viewing
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user may view the comments list.
     */
    public function viewAny(User $user): bool
    {
        return $this->canManageComments($user);
    }

    /**
     * Determine whether the user may view a comment.
     */
    public function view(User $user, Comment $comment): bool
    {
        return $this->canManageComments($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Creating
    |--------------------------------------------------------------------------
    */

    /**
     * Comments must be submitted through the public website.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Updating
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user may edit a comment.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $this->canManageComments($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Soft Deleting
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user may soft-delete a comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $this->canManageComments($user)
            && ! $this->isOwnComment($user, $comment);
    }

    /**
     * Determine whether the user may bulk soft-delete comments.
     *
     * The actual selected records must also be checked by the bulk action.
     */
    public function deleteAny(User $user): bool
    {
        return $this->canManageComments($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Restoring
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user may restore a deleted comment.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $this->canManageComments($user);
    }

    /**
     * Determine whether the user may bulk-restore comments.
     */
    public function restoreAny(User $user): bool
    {
        return $this->canManageComments($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Permanent Deletion
    |--------------------------------------------------------------------------
    */

    /**
     * Comments must never be permanently deleted through Filament.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Bulk permanent deletion is not allowed.
     */
    public function forceDeleteAny(User $user): bool
    {
        return false;
    }
}