<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesDetail extends Model
{
    use HasFactory;

    public $table = 'sales_details';
    public $primaryKey = 'sale_detail_id';

    protected $guarded = [
        'sale_detail_id',
        'subtotal'
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'sale_id');
    }
}
