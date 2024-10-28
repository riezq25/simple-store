<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    public $table = 'sales';
    public $primaryKey = 'sale_id';

    protected $guarded = [
        'sale_id',
        'sale_date'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SalesDetail::class, 'sale_id', 'sale_id');
    }
}
