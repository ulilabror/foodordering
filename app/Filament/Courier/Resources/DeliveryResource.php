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

    public static function canCreate(): bool
    {
        return false; // Ini akan menyembunyikan tombol "+ Create"
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return true; // Ini akan menyembunyikan tombol "Edit"
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false; // Ini akan menyembunyikan tombol "Delete"
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Atribut dari model Delivery
            Forms\Components\TextInput::make('id')
                ->label('Delivery ID')
                ->disabled(), // Read-only
            Forms\Components\Select::make('order_id')
                ->label('Order')
                ->relationship('order', 'id') // Relasi ke model Order
                // ->getOptionLabelUsing(fn ($value) => \App\Models\Order::find($value)?->user->name ?? 'Unknown')
                ->disabled(), // Read-only
            Forms\Components\Select::make('courier_id')
                ->label('Courier')
                // ->relationship('courier', 'user.name') // Relasi ke model Courier
                ->disabled(), // Read-only
            Forms\Components\TextInput::make('delivery_fee')
                ->label('Delivery Fee')
                ->numeric()
                ->disabled(), // Read-only
            Forms\Components\Select::make('delivery_status')
                ->label('Delivery Status')
                ->options([
                    'assigned' => 'Assigned',
                    'on_delivery' => 'On Delivery',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ])
                ->disabled(), // Read-only
            Forms\Components\TextInput::make('created_at')
                ->label('Created At')
                ->disabled(), // Read-only
            Forms\Components\TextInput::make('updated_at')
                ->label('Updated At')
                ->disabled(), // Read-only
                


            // // Relasi ke model Order
            // Forms\Components\Group::make([
            //     Forms\Components\TextInput::make('order.user.name')
            //         ->label('Customer Name')
            //         ->disabled(), // Read-only
            //     Forms\Components\TextInput::make('order.total_price')
            //         ->label('Total Price')
            //         ->numeric()
            //         ->disabled(), // Read-only
            //     Forms\Components\Textarea::make('order.delivery_address')
            //         ->label('Delivery Address')
            //         ->disabled(), // Read-only
            // ])->columnSpanFull(),

            // // Relasi ke model Courier
            // Forms\Components\Group::make([
            //     Forms\Components\TextInput::make('courier.user.name')
            //         ->label('Courier Name')
            //         ->disabled(), // Read-only
            //     Forms\Components\TextInput::make('courier.vehicle_type')
            //         ->label('Vehicle Type')
            //         ->disabled(), // Read-only
            //     Forms\Components\TextInput::make('courier.vehicle_plate')
            //         ->label('Vehicle Plate')
            //         ->disabled(), // Read-only
            // ])->columnSpanFull(),
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
                TextColumn::make('order.delivery.address')
                    ->label('Alamat Pengiriman') // Menampilkan alamat pengiriman
                    ->sortable()
                    ->searchable(),
                TextColumn::make('courier.user.name')
                    ->label('Nama Kurir')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.total_price')
                    ->label('Total Harga') // Menampilkan total harga dari tabel orders
                    ->money('IDR') // Format sebagai mata uang
                    ->sortable(),
                TextColumn::make('delivery_fee')
                    ->label('Biaya Pengiriman')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('delivery_status')
                    ->badge()
                    ->colors([
                        'secondary' => 'assigned',
                        'warning' => 'on_delivery',
                        'success' => 'delivered',
                    ])
                    ->label('Status'),
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
            ->modifyQueryUsing(function (\Illuminate\Database\Eloquent\Builder $query) {
                $user = auth()->user();
                $query->visibleToCourier($user);
            })
            ->actions([
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
                Tables\Actions\Action::make('batalkanPengiriman')
                    ->label('Batalkan Pengiriman')
                    ->action(function ($record) {
                        $record->update([
                            'delivery_status' => null, // Ubah status menjadi "Dibatalkan"
                        ]);

                        // Update status pesanan (orders.status) menjadi 'cancelled'
                        $record->order->update([
                            'status' => 'cancelled',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->visible(fn ($record) => in_array($record->delivery_status, ['assigned', 'on_delivery'])), // Tampilkan hanya jika status "Ditugaskan" atau "Sedang Dikirim"
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
