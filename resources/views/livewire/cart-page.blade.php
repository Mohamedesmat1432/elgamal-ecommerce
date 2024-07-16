<div>
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-3/4">
                    <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold">Product</th>
                                    <th class="text-left font-semibold">Price</th>
                                    <th class="text-left font-semibold">Quantity</th>
                                    <th class="text-left font-semibold">Total</th>
                                    <th class="text-left font-semibold">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart_items as $item)
                                    <tr wire:key="cart-item-{{ $item['item_id'] }}">
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <img class="h-16 w-16 mr-4" src="{{ url('storage', $item['image']) }}"
                                                    alt="{{ $item['name'] }}">
                                                <span class="font-semibold">{{ $item['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4">{{ $item['unit_amount'] }}</td>
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <button wire:click="decreaseQty({{ $item['item_id'] }})"
                                                    class="border rounded-md py-2 px-4 mr-2">-</button>
                                                <span class="text-center w-8">{{ $item['quantity'] }}</span>
                                                <button wire:click="increaseQty({{ $item['item_id'] }})"
                                                    class="border rounded-md py-2 px-4 ml-2">+</button>
                                            </div>
                                        </td>
                                        <td class="py-4">{{ Number::currency($item['total_amount'], 'INR') }}</td>
                                        <td>
                                            <button wire:click="removeFromCart({{ $item['item_id'] }})"
                                                class="bg-slate-100 border-2 border-slate-200 rounded-lg px-3 py-1 text-red-500 hover:bg-red-500 hover:text-slate-100 hover:border-red-600">
                                                <span wire:loading.remove
                                                    wire:target="removeFromCart({{ $item['item_id'] }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                </span>
                                                <span wire:loading
                                                    wire:target="removeFromCart({{ $item['item_id'] }})">Loading...</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- More product rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="md:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Summary</h2>
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>{{ Number::currency($grand_total ?? 0, 'INR') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Taxes</span>
                            <span>{{ Number::currency(0, 'INR') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Shipping</span>
                            <span>{{ Number::currency(0, 'INR') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">{{ Number::currency($grand_total ?? 0, 'INR') }}</span>
                        </div>
                        @if (!empty($cart_items))
                            <a wire:navigate href="{{ route('checkout') }}"
                                class="bg-blue-500 text-white text-center py-2 px-4 rounded-lg mt-4 w-full block">
                                Checkout
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
