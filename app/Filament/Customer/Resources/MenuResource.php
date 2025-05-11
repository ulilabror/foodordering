<?php

namespace App\Filament\Customer\Resources;

use App\Models\Menu;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Define form fields here if needed
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Menu Name')->sortable()->searchable(),
                TextColumn::make('category.name')->label('Category')->sortable(),
                TextColumn::make('price')->label('Price')->money('IDR'),
            ])
            ->actions([
                Action::make('addToBasket')
                    ->label('Add to Basket')
                    ->form([
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $basket = session()->get('basket', []);
                        $menuId = $record->id;

                        if (isset($basket[$menuId])) {
                            $basket[$menuId]['quantity'] += $data['quantity'];
                        } else {
                            $basket[$menuId] = [
                                'name' => $record->name,
                                'price' => $record->price,
                                'quantity' => $data['quantity'],
                            ];
                        }

                        session()->put('basket', $basket);
                    })
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
