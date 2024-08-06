<?php
namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\LinkAction;

class CustomLinkAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->url(route('nom.de.la.route'));
        $this->label('Nom du bouton');
    }
}