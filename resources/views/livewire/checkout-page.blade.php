<div>
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
            Checkout
        </h1>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            Shipping Address
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                    First Name
                                </label>
                                <div class="relative">
                                    <input wire:model="f_name"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none  @error('f_name') border-red-500 @enderror"
                                        id="first_name" type="text" />
                                    @error('f_name')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('f_name')
                                    <p class="text-xs text-red-600 mt-2" id="f_name-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Last Name
                                </label>
                                <div class="relative">
                                    <input wire:model="l_name"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('l_name') border-red-500 @enderror"
                                        id="last_name" type="text" />
                                    @error('l_name')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3 ">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('l_name')
                                    <p class="text-xs text-red-600 mt-2" id="l_name-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="phone">
                                Phone
                            </label>
                            <div class="relative">
                                <input wire:model="phone"
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('phone') border-red-500 @enderror"
                                    id="phone" type="text" />
                                @error('phone')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16" aria-hidden="true">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('phone')
                                <p class="text-xs text-red-600 mt-2" id="phone-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="street">
                                Street
                            </label>
                            <div class="relative">
                                <input wire:model="street"
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('street') border-red-500 @enderror"
                                    id="street" type="text" />
                                @error('street')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16" aria-hidden="true">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('street')
                                <p class="text-xs text-red-600 mt-2" id="street-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                City
                            </label>
                            <div class="relative">
                                <input wire:model="city"
                                    class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('city') border-red-500 @enderror"
                                    id="city" type="text" />
                                @error('city')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16" aria-hidden="true">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('city')
                                <p class="text-xs text-red-600 mt-2" id="city-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="country">
                                    Country
                                </label>
                                <div class="relative">
                                    <input wire:model="country"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('country') border-red-500 @enderror"
                                        id="country" type="text" />
                                    @error('country')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('country')
                                    <p class="text-xs text-red-600 mt-2" id="country-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip_code">
                                    ZIP Code
                                </label>
                                <div class="relative">
                                    <input wire:model="zip_code"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('zip_code') border-red-500 @enderror"
                                        id="zip_code" type="text" />
                                    @error('zip_code')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('zip_code')
                                    <p class="text-xs text-red-600 mt-2" id="zip_code-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-lg font-semibold mb-4">
                        Select Payment Method
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input class="hidden peer" id="cod" wire:model="payment_method" required
                                type="radio" value="cod" />
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border @error('payment_method') border-red-500 @enderror  rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="cod">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Cash on Delivery
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                    viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                        <li>
                            <input class="hidden peer" id="stripe" wire:model="payment_method" type="radio"
                                value="stripe">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border @error('payment_method') border-red-500 @enderror rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="stripe">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Stripe
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                    viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                    </ul>
                    @error('payment_method')
                        <p class="text-xs text-red-600 mt-2" id="zip_code-error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <!-- End Card -->
            </div>
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        ORDER SUMMARY
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Subtotal
                        </span>
                        <span>
                            {{ Number::currency($grand_total ?? 0, 'INR') }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Taxes
                        </span>
                        <span>
                            {{ Number::currency(0, 'INR') }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Shipping Cost
                        </span>
                        <span>
                            {{ Number::currency(0, 'INR') }}
                        </span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Grand Total
                        </span>
                        <span>
                            {{ Number::currency($grand_total ?? 0, 'INR') }}
                        </span>
                    </div>
                    </hr>
                </div>
                <button type="submit" wire:click="placeOrder"
                    class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                    <span wire:loading wire:target="placeOrder">Processing...</span>
                </button>
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @forelse ($cart_items as $item)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full"
                                            src="{{ $item['image'] }}">
                                        </img>
                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $item['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $item['quantity'] }}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ Number::currency($item['total_amount'] ?? 0, 'INR') }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    No data
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
