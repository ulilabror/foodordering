<?php

namespace App\Filament\Courier\Resources;

use App\Filament\Courier\Resources\DeliveryResource\Pages;
use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Pengiriman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->label('ID Pesanan')
                    ->required(),
                Select::make('courier_id')
                    ->label('Kurir')
                    ->relationship('courier', 'id')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name ?? '-')
                    ->default(fn() => auth()->user()->courier?->id)
                    ->required(),
                Forms\Components\TextInput::make('delivery_fee')
                    ->label('Biaya Pengiriman')
                    ->numeric()
                    ->required(),
                Select::make('delivery_status')
                    ->options([
                        'assigned' => 'Ditugaskan',
                        'on_delivery' => 'Sedang Dikirim',
                        'delivered' => 'Terkirim',
                    ])
                    ->label('Status Pengiriman')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID Pengiriman')
                    ->sortable(),
                TextColumn::make('order.id')
                    ->label('ID Pesanan')
                    ->sortable(),
                TextColumn::make('order.user.name')
                    ->label('Nama Pelanggan') // Menampilkan nama pelanggan
                    ->sortable()
                    ->searchable(),
                TextColumn::make('courier.user.name')
                    ->label('Nama Kurir')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('delivery_fee')
                    ->label('Biaya Pengiriman')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('delivery_status')
                    ->label('Status Pengiriman')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('delivery_status')
                    ->options([
                        'assigned' => 'Ditugaskan',
                        'on_delivery' => 'Sedang Dikirim',
                        'delivered' => 'Terkirim',
                    ])
                    ->label('Filter Status Pengiriman'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ambilPengiriman')
                    ->label('Ambil Pengiriman')
                    ->action(function ($record) {
                        $record->update([
                            'courier_id' => auth()->user()->courier?->id, // Tetapkan kurir yang sedang login
                            'delivery_status' => 'assigned', // Ubah status menjadi "Ditugaskan"
                        ]);
                    })
                    ->requiresConfirmation()
                    ->color('primary')
                    ->visible(fn ($record) => $record->delivery_status === null), // Tampilkan hanya jika status belum diatur
                Tables\Actions\Action::make('mulaiPengiriman')
                    ->label('Mulai Pengiriman')
                    ->action(function ($record) {
                        $record->update([
                            'delivery_status' => 'on_delivery',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->color('warning')
                    ->visible(fn ($record) => $record->delivery_status === 'assigned'), // Tampilkan hanya jika status "Ditugaskan"
                Tables\Actions\Action::make('selesaikanPengiriman')
                    ->label('Selesaikan Pengiriman')
                    ->action(function ($record) {
                        $record->update([
                            'delivery_status' => 'delivered',
                        ]);

                        // Update status pesanan (orders.status) menjadi 'delivered'
                        $record->order->update([
                            'status' => 'delivered',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->visible(fn ($record) => $record->delivery_status === 'on_delivery'), // Tampilkan hanya jika status "Sedang Dikirim"
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
