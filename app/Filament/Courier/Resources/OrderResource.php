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
    protected static ?string $navigationLabel = 'Riwayat Order ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => User::where('role', 'customer')->where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name)
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
                    ->dehydrated(true) // Ensures the value is saved to the database
                    ->disabled(fn($record) => $record && $record->exists) // Disabled for existing records
                    ->afterStateHydrated(fn($state, $record, $set) => $record ? $set('total_price', $record->orderItems->sum(fn($item) => $item->price * $item->quantity)) : null),
                Forms\Components\Textarea::make('delivery_address')
                    ->required()
                    ->columnSpanFull()
                    , // Only save if not empty
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name') // Show user name instead of ID
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->getStateUsing(function ($record) {
                        return $record->orderItems->sum(fn($item) => $item->price * $item->quantity);
                    })
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ambilOrder')
                    ->label('Ambil Order')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'processing' => 'Processing',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        // Update the status of the order
                        $record->status = $data['status'];
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
