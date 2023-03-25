<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
