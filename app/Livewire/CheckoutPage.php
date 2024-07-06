<?php

namespace App\Livewire;

use App\Helpers\Cart;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout Page')]
class CheckoutPage extends Component
{
    public string $f_name = '';
    public string $l_name = '';
    public string $phone = '';
    public string $street = '';
    public string $city = '';
    public string $country = '';
    public string $zip_code = '';
    public string $payment_method = '';

    public function rules()
    {
        return [
            'f_name' => 'required|string|max:50',
            'l_name' => 'required|string|max:50',
            'phone' => 'required|numeric|max:15',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|string|in:stripe,cod',
        ];
    }

    public function placeOrder()
    {
        $this->validate();
    }

    public function render()
    {
        $cart_items = Cart::all();

        $grand_total = Cart::calculateTotal($cart_items);

        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}
