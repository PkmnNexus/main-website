<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any articles.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor', 'author']);
    }

    /**
     * Determine whether the user can view the article.
     */
    public function view(User $user, Article $article): bool
    {
        return $user->hasAnyRole(['admin', 'editor', 'author']);
    }

    /**
     * Determine whether the user can create articles.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor', 'author']);
    }

    /**
     * Determine whether the user can update the article.
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->hasAnyRole(['admin', 'editor'])) {
            return true;
        }

        return $user->hasRole('author')
            && $article->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the article.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete any articles.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasRole('admin');
    }
}