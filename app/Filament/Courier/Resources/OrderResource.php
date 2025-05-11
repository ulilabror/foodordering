<?php

namespace App\Filament\Courier\Resources;

use App\Filament\Courier\Resources\OrderResource\Pages;
use App\Filament\Courier\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    //buatkan label
    protected static ?string $navigationLabel = 'Riwayat Pengiriman ';

    public static function canCreate(): bool
    {
        return false; // Ini akan menyembunyikan tombol "+ Create"
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => User::where('role', 'customer')->where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name)
                    ->required()
                    ->disabled(), // Disable this field
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->disabled(), // Disable this field
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'COD' => 'Cash on Delivery',
                        'Transfer' => 'Bank Transfer',
                        'QRIS' => 'QRIS',
                    ])
                    ->required()
                    ->disabled(), // Disable this field
                Forms\Components\TextInput::make('total_price')
                    ->label('Total Price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->disabled(), // Disable this field
                Forms\Components\Textarea::make('delivery.address')
                    ->label('Delivery Address')
                    ->required()
                    ->columnSpanFull()
                    ->disabled(), // Disable this field
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id') // Menampilkan ID pengguna
                    ->label('User ID')
                    ->sortable()
                    ->searchable()
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\TextColumn::make('user.name') // Menampilkan nama pengguna
                    ->label('User')
                    ->searchable()
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\BadgeColumn::make('status') // Menampilkan status pesanan dengan badge
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'primary' => 'pending',
                        'warning' => 'processing',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\TextColumn::make('payment_method') // Menampilkan metode pembayaran
                    ->label('Payment Method')
                    ->searchable()
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\TextColumn::make('total_price') // Menampilkan total harga
                    ->label('Total Price')
                    ->getStateUsing(function ($record) {
                        return $record->orderItems->sum(fn($item) => $item->price * $item->quantity);
                    })
                    ->money('IDR')
                    ->sortable()
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\TextColumn::make('delivery.delivery_fee') // Menampilkan biaya pengiriman
                    ->label('Delivery Fee')
                    ->money('IDR')
                    ->sortable()
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\TextColumn::make('created_at') // Menampilkan waktu pembuatan pesanan
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->url(null), // Nonaktifkan klik
                Tables\Columns\TextColumn::make('updated_at') // Menampilkan waktu pembaruan pesanan
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->url(null), // Nonaktifkan klik
            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                // Jika user adalah kurir
                if ($user->courier) {
                    $query->whereHas('delivery', function ($query) use ($user) {
                        $query->where('courier_id', $user->courier->id); // Hanya pengiriman milik kurir ini
                    })->whereIn('status', ['delivered', 'cancelled']); // Tampilkan pesanan dengan status "delivered" atau "cancelled"
                } else {
                    // Jika bukan kurir, tampilkan semua data dengan status "delivered" atau "cancelled"
                    $query->whereIn('status', ['delivered', 'cancelled']); // Tampilkan pesanan dengan status "delivered" atau "cancelled"
                }
            })
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\Action::make('ambilOrder')
                //     ->label('Ambil Order')
                //     ->form([
                //         Forms\Components\Select::make('status')
                //             ->label('Status')
                //             ->options([
                //                 'processing' => 'Processing',
                //                 'delivered' => 'Delivered',
                //                 'cancelled' => 'Cancelled',
                //             ])
                //             ->required(),
                //     ])
                //     ->action(function ($record, array $data) {
                //         // Update the status of the order
                //         $record->status = $data['status'];
                //         $record->save();
                //     })
                //     ->requiresConfirmation()
                //     ->color('success'),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //   OrderItemRelationManager::class,
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
}
