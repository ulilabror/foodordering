<?php

namespace App\Filament\Customer\Pages;

use App\Filament\Customer\Resources\DeliveryResource;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;

class Basket extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $view = 'filament.customer.pages.basket';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Keranjang';
    protected static ?string $title = 'Keranjang';

    public $paymentMethod = 'COD'; // Default metode pembayaran
    public $deliveryAddress = ''; // Default alamat pengiriman
    public $latitude = 102; // Default latitude (Jakarta)
    public $longitude = 11; // Default longitude (Jakarta)



    protected $listeners = [
        'setLatitudeLongitude' => 'updateLatLng',
        'setCoordinates'
    ];

    public function setCoordinates($lat, $lng)
    {
        $this->mountedActionsData['latitude'] = $lat;
        $this->mountedActionsData['longitude'] = $lng;

        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function updateLatLng($lat, $lng)
    {
        $this->mountedActionsData['latitude'] = $lat;
        $this->mountedActionsData['longitude'] = $lng;

        $this->latitude = $lat;
        $this->longitude = $lng;

        // Perbarui nilai di formulir
        $this->form->fill([
            'latitude' => $lat,
            'longitude' => $lng,
        ]);
    }

    public static function getNavigationBadge(): ?string
    {
        $basket = session()->get('basket', []);
        $totalItems = array_sum(array_column($basket, 'quantity'));

        return $totalItems > 0 ? (string) $totalItems : null;
    }

    public function getBasket()
    {
        return session()->get('basket', []);
    }

    public function removeFromBasket($menuId)
    {
        $basket = session()->get('basket', []);

        if (isset($basket[$menuId])) {
            unset($basket[$menuId]);
        }

        session()->put('basket', $basket);
    }

    public function reduceFromBasket($menuId)
    {
        $basket = session()->get('basket', []);

        if (isset($basket[$menuId])) {
            $basket[$menuId]['quantity']--;

            if ($basket[$menuId]['quantity'] <= 0) {
                unset($basket[$menuId]);
            }
        }

        session()->put('basket', $basket);
    }

    public function checkout()
    {
        $basket = session()->get('basket', []);

        if (empty($basket)) {
            Notification::make()
                ->title('Your basket is empty!')
                ->danger()
                ->send();
            return;
        }

        try {
            \DB::transaction(function () use ($basket) {
                // Simpan data ke tabel orders
                $order = \App\Models\Order::create([
                    'user_id' => auth()->id(),
                    'status' => 'pending',
                    'payment_method' => $this->paymentMethod,
                    'total_price' => collect($basket)->sum(fn($item) => $item['price'] * $item['quantity']),
                ]);

                // Simpan data ke tabel order_items
                foreach ($basket as $menuId => $item) {
                    $order->orderItems()->create([
                        'menu_id' => $menuId,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }

                // Update data delivery yang sudah dibuat secara otomatis oleh event di model Order
                $order->delivery()->update([
                    'address' => $this->deliveryAddress,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]);

                session()->forget('basket');

                Notification::make()
                    ->title('Checkout successful!')
                    ->success()
                    ->send();

                // Redirect ke halaman yang sesuai setelah checkout
                $this->redirect(DeliveryResource::getUrl());
            });
        } catch (\Exception $e) {
            Notification::make()
                ->title('Checkout failed!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // public function updatedLatitude($value)
    // {
    //     \Log::info('Latitude updated: ' . $value);
    // }

    // public function updatedLongitude($value)
    // {
    //     \Log::info('Longitude updated: ' . $value);
    // }

    protected function getActions(): array
    {
        return [
            Action::make('checkout')
                ->label('Checkout')
                ->form([
                    Forms\Components\Select::make('paymentMethod')
                        ->label('Metode Pembayaran')
                        ->options([
                            'COD' => 'Cash on Delivery (COD)',
                            'Transfer' => 'Bank Transfer',
                            'QRIS' => 'QRIS Payment',
                        ])
                        ->default('COD') // default langsung di field
                        ->required(),
                    Forms\Components\TextInput::make('deliveryAddress')
                        ->label('Alamat Pengiriman')
                        ->required()
                        ->reactive()
                        ->default($this->deliveryAddress), // default langsung di field

                    Forms\Components\ViewField::make('gps_map')
                        ->label('Pilih Lokasi')
                        ->view('components.fields.gps-picker-customer')
                        ->columnSpanFull(),

                    TextInput::make('latitude')
                        ->label('Latitude')
                        ->extraAttributes(['x-model' => 'latitude']) // Sinkronisasi dengan Alpine.js
                        ->readOnly()
                        ->required()
                        ->reactive(),

                    TextInput::make('longitude')
                        ->label('Longitude')
                        ->extraAttributes(['x-model' => 'longitude'])// Sinkronisasi dengan Alpine.js
                        ->readOnly()
                        ->required()
                        ->reactive(),
                    // default langsung di field
                ])
                ->action(function (array $data) {
                    // Simpan data form ke property untuk digunakan di checkout()
                    $this->paymentMethod = $data['paymentMethod'];
                    $this->latitude = $data['latitude'];
                    $this->longitude = $data['longitude'];
                    $this->deliveryAddress = $data['deliveryAddress'];
                    $this->checkout();
                })
                ->modalHeading('Form Pembayaran')
                ->modalButton('checkout')
                ->color('primary'),
        ];
    }




}
