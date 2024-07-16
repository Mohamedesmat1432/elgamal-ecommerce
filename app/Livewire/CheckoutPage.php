<?php

namespace App\Livewire;

use App\Helpers\Cart;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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
    public string $grand_total = '';
    public string $url = '';
    public array $cart_items = [];
    public array $line_items = [];

    public function rules()
    {
        return [
            'f_name' => 'required|string|max:50',
            'l_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|string|in:stripe,cod',
        ];
    }

    public function mount()
    {
        $this->cart_items = Cart::all();
        $this->grand_total = Cart::calculateTotal($this->cart_items);
    }

    public function placeOrder()
    {
        $this->validate();

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = $this->grand_total;
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->shipping_method = 'none';
        $order->shipping_amount = 0;
        $order->note = 'Order By ' . auth()->user()->name;

        $address = new Address();
        $address->f_name = $this->f_name;
        $address->l_name = $this->l_name;
        $address->phone = $this->phone;
        $address->street = $this->f_name;
        $address->street = $this->street;
        $address->city = $this->city;
        $address->country = $this->country;
        $address->zip_code = $this->zip_code;

        $this->checkPaymentData();

        $order->save();
        $order->orderItems()->createMany($this->cart_items);

        $address->order_id = $order->id;
        $address->save();

        Cart::clearAll();

        Mail::to(request()->user())->send(new OrderPlaced($order));

        return redirect($this->url);
    }

    public function checkPaymentData()
    {
        foreach ($this->cart_items as $item) {
            $this->line_items[] = [
                'price_data' => [
                    'currency' => 'INR',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [url('storage', $item['image'])],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(config('stripe.api_key.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $this->line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);

            $this->url = $session->url;
        } else {
            $this->url = route('success');
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
