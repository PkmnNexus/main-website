<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Validation\Rules\Password;
use UnitEnum;
use BackedEnum;

class EditProfile extends BaseEditProfile
{
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'My Profile';

    protected static string | \UnitEnum | null $navigationGroup = 'Users';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?int $navigationSort = 1;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('display_name')
                    ->label('Display name')
                    ->maxLength(255)
                    ->helperText('This name is displayed publicly with your articles.'),

                Textarea::make('bio')
                    ->label('Bio')
                    ->rows(4)
                    ->maxLength(1000)
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('avatar')
                    ->label('Avatar')
                    ->collection('user_avatar')
                    ->conversion('avatar-webp')
                    ->image()
                    ->imageEditor()
                    ->maxSize(2048)
                    ->helperText('Upload a profile picture (maximum 2 MB).'),

                $this->getEmailFormComponent(),

                TextInput::make('password')
                    ->label('New password')
                    ->password()
                    ->revealable()
                    ->rule(Password::default())
                    ->autocomplete('new-password')
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->dehydrateStateUsing(fn (string $state): string => $state),

                TextInput::make('password_confirmation')
                    ->label('Confirm new password')
                    ->password()
                    ->revealable()
                    ->same('password')
                    ->dehydrated(false)
                    ->autocomplete('new-password'),
            ]);
    }
}