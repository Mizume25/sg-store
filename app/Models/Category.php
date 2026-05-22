<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Category extends Model
{
    /**
     * Modelo Category - Relacion Autoreflexiva 
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_id'
    ];

    /**
     * Funciones de Relación
     */

    /**
     * Relacion una categoria tiene varias categorias hijas
     * @return HasMany  
     */
    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relación con categoría padre
     * Una categoría puede pertenecer a una categoría padre
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    /**
     * Relación N:M con productos
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'categories_products');
    }


    
}
