<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProductsImage extends Model
{
    protected $fillable = [
        'path',
        'product_id'
    ];

    /**
     * Funcion de Relaciones
     */

    /**
     * Relación con el producto al que pertenece
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
