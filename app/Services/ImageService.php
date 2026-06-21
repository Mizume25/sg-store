<?php

namespace App\Services;


use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Http\UploadedFile;


/**
 * 
 * Servicio de Gestion de imagenes
 */
class ImageService
{
    /** Funciones Principales */

    /**
     * Subir imagen a la BD
     * @param UploadedFile $img 
     * @param string $path
     * @param int $productId
     */
    public function upload(?UploadedFile $img, string $path, int $productId): void
    {
        /** Si la imagene es nula, no hacemos nada */
        if ($img == null) return;

        /** Construimos la ruta */
        $dest = public_path($path);

        /** Si no exite la creamos */
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        $name = $img->getClientOriginalName();
    
        /** Ponemos la imagen en el directorio */
        $img->move($dest, $name);

        /** Creamos los metadatos */
        $this->store($name, $productId);
    }

    /**
     * 
     * Crear datos en BD
     * @param string $name
     * @param int $productID
     */
    private function store(string $name, int $productID)
    {
        /** Crea objeto en BD */
        ProductsImage::create([
            'path' => $name,
            'product_id' => $productID
        ]);
    }


    /** 
     * Borrar Imagen Especifica
     * @param int $id
     */
    public function delete(int $id): void
    {
        /** Buscamos la imagen */
        $img = ProductsImage::findOrFail($id);

        $product = Product::findOrFail($img->product_id);

        /** Si existe el directorio lo borramos */
        if (file_exists(public_path($product->code . '/' . $img->path))) unlink(public_path($product->code . '/' . $img->path));

        /** Borramos la imagen */
        $img->delete();
    }

    /**
     * 
     * Borrar todas las imagenes relacionadas con un producto
     * @param int $productID
     */
    public function remove(int $productID): void
    {
        /** Obtenemos imagenes relacionadas */
        $images = ProductsImage::where('product_id', $productID)->get();

        /** Iteramos anterior funcion  anterior */
        foreach ($images as $image) {
            $this->delete($image->id);
        }
    }

 

    /**
     * 
     * Remplazar imagenes 
     * @param int $id
     * @param UploadedFile $new 
     * @param string $path 
     * @param int $productID
     */
    public function replace(int $id, UploadedFile $new, string $path, int $productID): void
    {
        /** Boramos registro */
        $this->delete($id);

        /** Subimos el archivo  */
        $this->upload($new, $path, $productID);
    }

    

  
}
