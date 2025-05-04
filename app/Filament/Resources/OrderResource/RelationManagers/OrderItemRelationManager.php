<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

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
    protected static string $relationship = 'orderItems'; // Define the relationship name

    protected static ?string $recordTitleAttribute = 'order_id';

    public function form(Forms\Form $form): Forms\Form // Removed static keyword
    {
        return $form
            ->schema([
                Select::make('menu_id')
                    ->label('Menu')
                    ->relationship('menu', 'name') // Dropdown for menus
                    ->required()
                    ->reactive() // Make it reactive to trigger updates
                    ->afterStateUpdated(function (callable $set, $state) {
                        $menu = Menu::find($state);
                        if ($menu) {
                            $set('price', $menu->price); // Set price based on selected menu
                        }
                    }),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->required()
                    ->reactive() // Make it reactive to trigger updates
                    ->afterStateUpdated(function (callable $set, $state, $get) {
                        $price = $get('price');
                        if ($price) {
                            $set('price', $price * $state); // Update price based on quantity
                        }
                    }),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
                    ->disabled() // Disable manual editing of price
                    ->dehydrated(true), // Ensure the value is saved to the database
            ]);
    }

    public function table(Tables\Table $table): Tables\Table // Removed static keyword
    {
        return $table
            ->columns([
                TextColumn::make('menu.name') // Show menu name
                    ->label('Menu')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\CreateAction::make()
                //     ->label('Add Menu Item')
                //     ->form([
                //         Select::make('menu_id')
                //             ->label('Menu')
                //             ->relationship('menu', 'name') // Dropdown for menus
                //             ->required(),
                //         TextInput::make('quantity')
                //             ->label('Quantity')
                //             ->numeric()
                //             ->required(),
                //         TextInput::make('price')
                //             ->label('Price')
                //             ->numeric()
                //             ->required(),
                //     ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}