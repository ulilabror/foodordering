<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ProfilePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile-page';
}
