<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Success Page')]
class SuccessPage extends Component
{
    #[Url]
    public $session_id;

    public function render()
    {
        $order = Order::with('address')
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->first();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = Session::retrieve($this->session_id);

            if ($session->payment_status != 'paid') {
                $order->payment_status = 'failed';
                $order->save();
                $this->redirect(route('cancel'), navigate: true);
            } elseif ($session->payment_status == 'paid') {
                $order->payment_status = 'paid';
                $order->save();
            }
        }

        return view('livewire.success-page', [
            'order' => $order,
        ]);
    }
}
