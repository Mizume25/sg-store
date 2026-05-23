<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Rate extends Model
{   
    /**Señalamos que usa Factory */
    use HasFactory;

    protected $fillable = [
        'price',
        'start_date',
        'end_date',
        'product_id'
    ];

    /**
     * Funcion de Relaciones
     */

    /**
     * Relacion una tarifa pertence a un producto
     * @return BelongsTo
     */
    public function product () 
    {
        return $this->belongsTo(Product::class);
    }
}
