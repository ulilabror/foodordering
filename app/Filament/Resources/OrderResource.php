<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => User::where('role', 'customer')->where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name)
                    ->options(User::where('role', 'customer')->pluck('name', 'id')->toArray()) // Added options
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'COD' => 'Cash on Delivery',
                        'Transfer' => 'Bank Transfer',
                        'QRIS' => 'QRIS',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->label('Total Price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->default(fn($record) => $record && !$record->exists ? $record->orderItems->sum(fn($item) => $item->price * $item->quantity) : 0)
                    ->disabled(fn($record) => $record && $record->exists) // Disabled for existing records
                    ->dehydrated(true) // Ensures the value is saved to the database
                    ->reactive()
                    ->hidden(fn($state) => $state === 0 || $state === null) // Hide when value is 0 or null
                    ->afterStateHydrated(fn($state, $record, $set) => $record ? $set('total_price', $record->orderItems->sum(fn($item) => $item->price * $item->quantity)) : null),
                Forms\Components\Textarea::make('delivery.address')
                    ->label('Delivery Address')
                    ->required()
                    ->columnSpanFull()
                    ->saveRelationshipsUsing(function ($record, $state) {
                        $record->delivery->update(['address' => $state]);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id') // Menampilkan ID Pesanan
                    ->label('Pesanan ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name') // Menampilkan nama pengguna
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status') // Menampilkan status pesanan
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method') // Menampilkan metode pembayaran
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price') // Menampilkan total harga
                    ->label('Total Price')
                    ->getStateUsing(function ($record) {
                        return $record->orderItems->sum(fn($item) => $item->price * $item->quantity);
                    })
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at') // Menampilkan waktu pembuatan pesanan
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at') // Menampilkan waktu pembaruan pesanan
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            OrderItemRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigation(): array
    {
        return [
            'label' => 'Orders',
            'icon' => 'heroicon-o-receipt-refund',
            'group' => 'Manajemen Pesanan',
            'sort' => 2,
        ];
    }
}
