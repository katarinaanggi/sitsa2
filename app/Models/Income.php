<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;

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
        'total' => 'integer',
    ];

    /**
     * Get the admin that owns the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    // protected $dates = [
    //     'date'
    // ];

    // /**
    //  * Set the date attribute.
    //  *
    //  * @param  string  $value
    //  * @return void
    //  */
    // public function setDateAttribute($value)
    // {
    //     $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $value);
    // }
}
