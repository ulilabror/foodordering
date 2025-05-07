<?php

namespace App\Filament\Courier\Resources;

use App\Filament\Courier\Resources\CourierResource\Pages;
use App\Models\Courier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

class CourierResource extends Resource
{
    protected static ?string $model = Courier::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Courier Setup';

    // Show menu only if courier profile doesn't exist
    public static function shouldRegisterNavigation(): bool
    {
        return false;
        // return !auth()->user()?->courier;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('address')->required(),
            Forms\Components\TextInput::make('gps_latitude')
                ->label('Latitude')
                ->required()
                ->numeric()
                ->readOnly(),
            Forms\Components\TextInput::make('gps_longitude')
                ->label('Longitude')
                ->required()
                ->numeric()
                ->readOnly(),
            Forms\Components\ViewField::make('gps_map')
                ->label('Pilih Lokasi')
                ->view('components.fields.gps-picker')
                ->columnSpanFull(),
            
            Forms\Components\TextInput::make('vehicle_type')->required(),
            Forms\Components\TextInput::make('vehicle_plate')->required(),
            Forms\Components\Toggle::make('is_partner')->required(),

        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateCourier::route('/'),
            'create' => Pages\CreateCourier::route('/create'),
        ];
    }


    public static function getNavigationUrl(): string
    {
        return static::getUrl('create');
    }



    public static function getModelLabel(): string
    {
        return 'Courier Registration';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Courier Registration';
    }
}
