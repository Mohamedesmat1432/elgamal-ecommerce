<?php
namespace App\Helpers;

use App\Models\Item;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    //Add item to cart
    public static function add($item_id, $qty = 1)
    {
        $cart_items = self::all();
        $old_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['item_id'] && $item['item_id'] == $item_id) {
                $old_item = $key;
                break;
            }
        }

        if ($old_item !== null) {
            $cart_items[$old_item]['quantity']++;
            $cart_items[$old_item]['total_amount'] = $cart_items[$old_item]['quantity'] * $cart_items[$old_item]['unit_amount'];
        } else {
            $item = Item::where('id', $item_id)->first(['id', 'name', 'price', 'images']);
            $cart_items[] = [
                'item_id' => $item->id,
                'name' => $item->name,
                'image' => !empty($item->images) ? $item->images[0] : '',
                'quantity' => $qty,
                'unit_amount' => $item->price,
                'total_amount' => $item->price,
            ];
        }

        self::addToCookie($cart_items);
        return count($cart_items);
    }

    //Remove item to cart
    public static function remove($item_id)
    {
        $cart_items = self::all();

        foreach ($cart_items as $key => $item) {
            if ($item['item_id'] == $item_id) {
                unset($cart_items[$key]);
            }
        }

        self::addToCookie($cart_items);
        return $cart_items;
    }

    //Add cart items to cookie
    public static function addToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 60);
    }

    //Remove cart items to cookie
    public static function clearFromCookie()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    //All cart items from cookie
    public static function all()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        return $cart_items ? $cart_items : [];
    }

    //Icrement item quantity
    public static function increase($item_id)
    {
        $cart_items = self::all();

        foreach ($cart_items as $key => $item) {
            if ($item['item_id'] == $item_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addToCookie($cart_items);
        return $cart_items;
    }

    //Decrement item quantity
    public static function decrease($item_id)
    {
        $cart_items = self::all();

        foreach ($cart_items as $key => $item) {
            if ($item['item_id'] == $item_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }

        self::addToCookie($cart_items);
        return $cart_items;
    }

    //Calculate grant total
    public static function calculateTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
