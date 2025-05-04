<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($menuItems as $menu)
            <div class="bg-white shadow rounded-lg p-4">
                <img src="{{ asset($menu->image_path) }}" alt="{{ $menu->name }}" class="w-full h-40 object-cover rounded">
                <h3 class="text-lg font-bold mt-2">{{ $menu->name }}</h3>
                <p class="text-gray-600">{{ $menu->description }}</p>
                <p class="text-gray-800 font-bold mt-2">${{ number_format($menu->price, 2) }}</p>
                <button 
                    wire:click="addToBasket({{ $menu->id }})" 
                    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Add to Basket
                </button>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-bold">Basket</h2>
        @if (count($basket) > 0)
            <ul class="mt-4">
                @foreach ($basket as $menuId => $item)
                    <li class="flex justify-between items-center border-b py-2">
                        <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        <button 
                            wire:click="removeFromBasket({{ $menuId }})" 
                            class="text-red-500 hover:underline">
                            Remove
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">
                <strong>Total:</strong> ${{ number_format(collect($basket)->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}
            </div>
        @else
            <p class="text-gray-600">Your basket is empty.</p>
        @endif
    </div>
</x-filament::page>
