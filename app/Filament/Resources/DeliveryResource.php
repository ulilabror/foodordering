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

    protected static ?string $label = 'penugasan kurir';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->label('Order')
                    ->options(function () {
                        return \App\Models\Order::with('user')
                            ->get()
                            ->mapWithKeys(function ($order) {
                                return [$order->id => "Order #{$order->id} - {$order->user->name}"];
                            })
                            ->toArray();
                    }) // Menampilkan nama user yang memesan
                    ->searchable()
                    ->required(),

                Select::make('courier_id')
                    ->label('Courier')
                    ->options(function () {
                        return \App\Models\Courier::with('user')
                            // ->whereHas('user', function ($query) {
                            //     $query->where('is_online', true); // Hanya kurir yang sedang online
                            // })
                            ->get()
                            ->mapWithKeys(function ($courier) {
                                return [$courier->id => "{$courier->user->name}"];
                            })
                            ->toArray();
                    }) // Menampilkan nama kurir
                    ->searchable()
                    ->required(),
                TextInput::make('delivery_fee')
                    ->label('Delivery Fee')
                    ->numeric()
                    ->required(),
                Select::make('delivery_status')
                    ->options([
                        'assigned' => 'Assigned',
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
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('order.id')
                    ->label('Order ID')
                    ->sortable(),
                TextColumn::make('courier.user.id')
                    ->label('Courier User Id') // Menampilkan nama user dari courier
                    ->sortable()
                    ->searchable(),
                TextColumn::make('courier.user.name')
                    ->label('Courier Name') // Menampilkan nama user dari courier
                    ->sortable()
                    ->searchable(),  
                TextColumn::make('courier.vehicle_type')
                    ->label('Vehicle Type')
                    ->sortable(),
                TextColumn::make('courier.vehicle_plate')
                    ->label('Vehicle Plate')
                    ->sortable(),
                TextColumn::make('delivery_fee')
                    ->label('Delivery Fee')
                    ->money('IDR') // Format sebagai mata uang
                    ->sortable(),
                TextColumn::make('delivery_status')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('delivery_status')
                    ->options([
                        'assigned' => 'Assigned',
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
