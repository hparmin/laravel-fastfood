<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items');
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function getStatusAttribute($status)
    {
        switch ($status) {
            case '0' :
                return "در انتظار پرداخت";
                break;
            case '1' :
                return "در حال پردازش";
                break;
            case '3' :
                return "ارسال شده";
                break;
            case '4' :
                return "کنسل شده";
                break;
        }
    }

}
