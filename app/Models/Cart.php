<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\Cart_Detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are not assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    protected $with = ['cart_details'];

    /**
     * Get the user that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the cart_details for the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart_details()
    {
        return $this->hasMany(Cart_Detail::class);
    }

    // public $cart_details = null;
    // public $totalQty = 0;
    // public $totalPrice = 0;

    // public function __construct($oldCart)
    // {
    //     if ($oldCart)
    //     {
    //         $cart_details = new Cart_Detail();
    //         $this->cart_details = $oldCart->cart_details;
    //         // $this->totalQty = $oldCart->totalQty;
    //         // $this->totalPrice = $oldCart->totalPrice;
    //     }
    // }

    public function updateItem($cart_detail, $id, $jumlah) {
            $this->cart_details[$id]['jumlah'] = $jumlah;
            // $this->cart_details[$id]['price'] = $jumlah * $item->price;
            // $this->totalQty = $this->cart_details[$id]['jumlah'];
            // $this->totalPrice = $this->totalQty * $item->price;
    }
}
