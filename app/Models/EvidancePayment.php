<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidancePayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'evidance_payment';
}
