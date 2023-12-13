<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'order';

    public function product() : HasMany
    {
        return $this->hasMany(Product::class, 'id', 'products_id');
    }

    public function methodPayment() : HasOne
    {
        return $this->hasOne(MethodPayment::class, 'id', 'payment_method');
    }
}
