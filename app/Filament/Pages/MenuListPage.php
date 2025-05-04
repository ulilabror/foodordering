<?php

namespace App\Filament\Pages;

use App\Models\Menu;
use Filament\Pages\Page;

class MenuListPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.menu-list-page';

    public $basket = [];

    public function addToBasket($menuId)
    {
        $menu = Menu::find($menuId);

        if ($menu) {
            $this->basket[$menuId] = [
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => ($this->basket[$menuId]['quantity'] ?? 0) + 1,
            ];
        }
    }

    public function removeFromBasket($menuId)
    {
        if (isset($this->basket[$menuId])) {
            unset($this->basket[$menuId]);
        }
    }

    public function getMenuItemsProperty()
    {
        return Menu::where('is_available', true)->get();
    }
}
