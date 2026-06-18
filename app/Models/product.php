<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    protected $appends = "is_sale";

    public function getIsSaleAttribute()
    {
        return $this->quantity > 0 && $this->sale_price !== 0 && $this->sale_price !== null && $this->date_on_sale_from < Carbon::now('Asia/Tehran') && $this->date_on_sale_to > Carbon::now('Asia/Tehran');
    }

}
