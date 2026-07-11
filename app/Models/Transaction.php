<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'transactions';
    protected $guarded = [];

    public function getStatusAttribute($status)
    {
        switch ($status){
            case '0':
                return 'نا موفق';
                break;
            case '1':
                return 'موفق';
                break;
        }
    }
}
