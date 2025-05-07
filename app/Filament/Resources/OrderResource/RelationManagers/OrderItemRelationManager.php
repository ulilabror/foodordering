<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class OrderItemRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('menu_id')
                    ->label('Menu')
                    ->relationship('menu', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('price', Menu::find($state)?->price)),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('total_price',$this->updateOrderTotalPrice()?->total_price)),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
                    ->disabled()
                    ->dehydrated(true)
                    ->default(fn ($get) => Menu::find($get('menu_id'))?->price),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('menu.name')->label('Menu')->searchable(),
                TextColumn::make('quantity')->label('Quantity')->sortable(),
                TextColumn::make('price')->label('Price')->money('IDR')->sortable(),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    protected function afterSave(): void
    {
        $this->updateOrderTotalPrice();
    }

    protected function afterDelete(): void
    {
        $this->updateOrderTotalPrice();
    }

    private function updateOrderTotalPrice(): void
    {
        $order = $this->ownerRecord; // Access the parent Order record
        $order->recalculateTotalPrice(); // Call the recalculateTotalPrice method from the Order model
    }
}