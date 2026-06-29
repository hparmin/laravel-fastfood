<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    protected $table = 'cart_items';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'qty'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
