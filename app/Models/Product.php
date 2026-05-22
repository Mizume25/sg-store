<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description'
    ];


    /**
     * Funcion de Relaciones
     */

    /**
     * Relacion con muchas categories
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_products');
    }

    /**
     * Relacion con varias taridas
     * @return HasMany
     */
    public function rates()
    {
        return $this->hasMany(Rate::class, 'product_id');
    }

    /**
     * Relación con las imágenes del producto
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
