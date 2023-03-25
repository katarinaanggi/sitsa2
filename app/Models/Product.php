<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Cart_Detail;
use App\Models\Order_Detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are not assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    
    protected $with = ['order_details', 'category', 'brand'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    /**
     * The roles that has many Product
     * ANGGI
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart_details() {
        return $this->hasMany(Cart_Detail::class);
    }

    /**
     * Get all of the order_details for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_details() {
        return $this->hasMany(Order_Detail::class);
    }


    public function scopeFilter($query, array $filters){
        // dd($filters);
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where(function ($query) use ($search)
            {
                $query->where('products.nama', 'like', '%'.$search.'%')
                    ->orWhere('deskripsi', 'like', '%'.$search.'%')
                    ->orWhere('brands.nama', 'like', '%'.$search.'%')
                    ->orWhere('categories.nama', 'like', '%'.$search.'%');
            });
        });

        $query->when($filters['category'] ?? false, function($query, $category){
            return $query->where('category_id', $category);
        });

        $query->when($filters['brand'] ?? false, function($query, $brand){
            return $query->where('brand_id', $brand);
        });
    }
}
