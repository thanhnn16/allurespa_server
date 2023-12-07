<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosmetic extends Model
{
    use HasFactory;

    protected $fillable = [
        'cosmetic_name',
        'price',
        'description',
        'image',
        'cosmetic_category_id',
        'purpose',
        'ingredients',
        'how_to_use',
    ];

    public function cosmeticCategory()
    {
        return $this->belongsTo(CosmeticCategory::class);
    }

    public function invoiceCosmetics()
    {
        return $this->hasMany(InvoiceCosmetic::class);
    }

}
