<?php

namespace Chapa\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'amount',
        'tx_ref'
    ];
}
