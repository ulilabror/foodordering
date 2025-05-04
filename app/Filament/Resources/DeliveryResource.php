<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->label('Order')
                    ->required(),
                Select::make('courier_id')
                    ->relationship('courier', 'name')
                    ->label('Courier')
                    ->required(),
                TextInput::make('delivery_fee')
                    ->label('Delivery Fee')
                    ->numeric()
                    ->required(),
                Select::make('delivery_status')
                    ->options([
                        'pending' => 'Pending',
                        'on_delivery' => 'On Delivery',
                        'delivered' => 'Delivered',
                    ])
                    ->label('Delivery Status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('order.id')->label('Order ID')->sortable(),
                TextColumn::make('courier.name')->label('Courier')->sortable(),
                TextColumn::make('delivery_fee')->label('Delivery Fee')->money('USD'),
                TextColumn::make('delivery_status')->label('Status')->sortable(),
                TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('delivery_status')
                    ->options([
                        'pending' => 'Pending',
                        'on_delivery' => 'On Delivery',
                        'delivered' => 'Delivered',
                    ])
                    ->label('Delivery Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships if needed, e.g., orders or couriers
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }

    public static function getNavigation(): array
    {
        return [
            'label' => 'Deliveries',
            'icon' => 'heroicon-o-truck',
            'group' => 'Pengiriman',
            'sort' => 4,
        ];
    }
}
