<?php

namespace App\Filament\Courier\Resources;

use App\Filament\Courier\Resources\DeliveryResource\Pages;
use App\Filament\Courier\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use function Laravel\Prompts\alert;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->relationship('order', 'id') // Dropdown untuk memilih order
                    ->label('Order')
                    ->required(),

                    // perbaiki kurir tidak seach available dan hanya tampilkan role kurir dan sedang online
                    

                    Select::make('courier_id')
                        ->label('Courier')
                        ->relationship('courier', 'id')
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name ?? '-')
                        ->default(fn() => auth()->user()->courier?->id) // harus id dari model Courier, bukan user_id
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
            //
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
}
