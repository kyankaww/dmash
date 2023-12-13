<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MethodPayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'method_payment';

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class);
    }
}
