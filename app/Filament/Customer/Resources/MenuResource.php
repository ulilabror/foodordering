<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Pages\Basket;
use App\Models\Menu;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Livewire\Livewire;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getLabel(): string
    {
        return 'Menu';
    }
    public static function getPluralLabel(): string
    {
        return 'Menu';
    }

    public static function getNavigationLabel(): string
    {
        return 'Menu';
    }



    public static function canCreate(): bool
    {
        return false; // Disable create action
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false; // Disable delete action
    }

    public static function canDeleteAny(): bool
    {
        return false; // Disable delete action
    }
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false; // Disable delete action
    }

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
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Photo')
                    ->disk('public') // Specify the disk where images are stored
                    ->height('150px')
                    ->width('100%'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->size('lg'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->color('secondary'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Category')
                    ->relationship('category', 'name') // Relasi ke model kategori
                    ->placeholder('All Categories'), // Placeholder untuk filter
            ])
            ->actions([
                Action::make('addToBasket')
                    ->label('Add to Basket')
                    ->form([
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set, $get) => $set('total_price', $get('price') * $state)),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->default(fn($record) => $record->price)
                            ->disabled(),
                        TextInput::make('total_price')
                            ->label('Total Price')
                            ->numeric()
                            ->default(fn($record) => $record->price)
                            ->disabled(),
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
                                'image_path' => $record->image_path,
                            ];
                        }

                        session()->put('basket', $basket);

                        // Tambahkan flash message untuk notifikasi
                        session()->flash('message', 'Item added to basket!');

                        // Refresh halaman setelah aksi selesai
                        return redirect(request()->header('Referer'));
                    })
                    ->color('primary')
                    ->icon('heroicon-o-shopping-cart'),
            ])
            ->headerActions([
                Action::make('viewBasket')
                    ->label('Lihat Pesanan')
                    ->url(Basket::getNavigationUrl()) // Mengarahkan ke halaman Basket
                    ->color('info')
                    ->icon('heroicon-o-eye'),
                Action::make('checkout')
                    ->label('Checkout')
                    ->action(function () {
                        // Implement checkout logic here
                        session()->forget('basket');
                        \Filament\Notifications\Notification::make()
                            ->title('Checkout successful!')
                            ->success()
                            ->send();
                    })
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation(),
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
            'index' => MenuResource\Pages\ListMenus::route('/'),
            'create' => MenuResource\Pages\CreateMenu::route('/create'),
            'edit' => MenuResource\Pages\EditMenu::route('/{record}/edit'),
            // 'basket' => \App\Http\Livewire\Basket::class,
            // 'basket' => MenuResource\Pages\Basket::route('/basket'), // Tambahkan halaman Basket
        ];
    }

    public static function getNavigation(): array
    {
        return [
            // 'label' => 'Menus',
            // 'icon' => 'heroicon-o-collection',
            // 'group' => 'Customer Management',
            // 'sort' => 1, // Adjust the order in the navigation menu
        ];
    }
}

