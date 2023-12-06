<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCosmetic extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'cosmetic_id',
        'cosmetic_quantity',
        'total_amount',
        'created_at',
        'updated_at',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
