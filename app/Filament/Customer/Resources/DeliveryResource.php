<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\DeliveryResource\Pages;
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
use Filament\Tables\Actions\Action;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Pengiriman';

    protected static ?int $navigationSort = 4;

    protected $listeners = ['showMap'];

    public $mapLatitude;
    public $mapLongitude;

    public static function canCreate(): bool
    {
        return false; // Disable create action
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false; // Disable edit action
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false; // Disable delete action
    }

    public static function canDeleteAny(): bool
    {
        return false; // Disable delete action
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('order', function ($query) {
            $query->where('user_id', auth()->id());
            })
            ->where(function ($query) {
            $query->whereNotIn('delivery_status', ['cancelled', 'delivered'])
                  ->orWhereNull('delivery_status');
            });
    }

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
                    })
                    ->searchable()
                    ->required(),

                Select::make('courier_id')
                    ->label('Courier')
                    ->options(function () {
                        return \App\Models\Courier::with('user')
                            ->get()
                            ->mapWithKeys(function ($courier) {
                                return [$courier->id => "{$courier->user->name}"];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('delivery_fee')
                    ->label('Delivery Fee')
                    ->numeric()
                    ->required(),

                Select::make('delivery_status')
                    ->label('Delivery Status')
                    ->options([
                        'assigned' => 'Assigned',
                        'on_delivery' => 'On Delivery',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),

                TextInput::make('address')
                    ->label('Delivery Address')
                    ->required(),

                TextInput::make('latitude')
                    ->label('Latitude')
                    ->numeric()
                    ->required(),

                TextInput::make('longitude')
                    ->label('Longitude')
                    ->numeric()
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

                TextColumn::make('order.user.name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('courier.user.name')
                    ->label('Courier Name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => $state ?? 'Belum Ditugaskan'),

                TextColumn::make('delivery_fee')
                    ->label('Delivery Fee')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('delivery_status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'info' => 'assigned',
                        'warning' => 'on_delivery',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ?? 'Belum Ada'),

                TextColumn::make('address')
                    ->label('Address')
                    ->searchable(),

                // Menampilkan latitude dari relasi courier
                TextColumn::make('courier.gps_latitude')
                    ->label('Courier Latitude')
                    ->sortable(),

                // Menampilkan longitude dari relasi courier
                TextColumn::make('courier.gps_longitude')
                    ->label('Courier Longitude')
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
                        'assigned' => 'Ditugaskan',
                        'on_delivery' => 'Dalam Pengiriman',
                        'delivered' => 'Diterima',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->label('status pengiriman'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('view_map')
                    ->label('View Map')
                    ->icon('heroicon-o-map')
                    ->modalHeading('Delivery Location')
                    ->modalSubheading('View the delivery location on the map.')
                    ->modalCloseButton(false)
                    ->modalCancelActionLabel('Close')
                    ->modalSubmitAction(false)
                    ->modalSubmitActionLabel('Close')
                    ->modalContent(fn($record) => view('components.fields.delivery-map', [
                        'latitude' => $record->courier->gps_latitude ?? null,
                        'longitude' => $record->courier->gps_longitude ?? null,
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships if needed
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

    public function showMap($latitude, $longitude)
    {
        $this->mapLatitude = $latitude;
        $this->mapLongitude = $longitude;

        $this->dispatchBrowserEvent('open-map-modal');
    }
}