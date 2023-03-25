<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_Detail extends Model
{
    use HasFactory;
    public $table = "cart_details";

    /**
     * The attributes that are not assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah' => 'integer',
    ];

    /**
     * Get the cart that owns the Cart_Detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product that owns the Cart_Detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
