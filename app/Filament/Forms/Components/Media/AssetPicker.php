<?php

namespace App\Filament\Forms\Components\Media;

use App\Models\Asset;
use Filament\Actions\Action;
use Filament\Forms\Components\Field;

class AssetPicker extends Field
{
    protected string $view = 'filament.forms.components.asset-picker';

    public function getSelectedAsset(): ?Asset
    {
        return Asset::find($this->getState());
    }

    public function getBrowseAction(): Action
    {
        return Action::make('browseAssets')
            ->label('Select image')
            ->modalHeading('Asset browser')
            ->modalWidth('7xl')
            ->modalSubmitAction(false)
            ->modalContent(fn () => view('filament.forms.components.asset-browser'));
    }

    public function setSelectedAsset(int $assetId): static
    {
        $this->state($assetId);

        return $this;
    }
}