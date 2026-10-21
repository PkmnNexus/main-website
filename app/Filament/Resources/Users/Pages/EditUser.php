<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Prevent users from editing their own account through this resource.
     */
    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_if(
            $this->record->is(Auth::user()),
            403,
            'You cannot edit your own account here.',
        );
    }
}