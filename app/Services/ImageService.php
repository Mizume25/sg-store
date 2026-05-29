<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

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

        /** Creamos un id unico */
        $name = uniqid() . '.' . $img->getClientOriginalExtension();

        /** Ponemos la imagen en el directorio */
        $img->move($dest, $name);

        /** Creamos los metadatos */
        $this->store($path, $name, $productId);
    }

    /**
     * 
     * Crear datos en BD
     * @param string $path
     * @param string $name
     * @param int $productID
     */
    private function store(string $path, string $name, int $productID)
    {
        /** Crea objeto en BD */
        ProductsImage::create([
            'path' => $path . '/' . $name,
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

        /** Si existe el directorio lo borramos */
        if (file_exists(public_path($img->path))) unlink(public_path($img->path));

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

    /** Funcion para reorganizar carpetas en caso de upadtes a subcategories 
     * @param Product $product
     * @param string $oldPath
     * @param string $newPath
     */
    public function reorganize(Product $product, string $oldPath, string $newPath): void
    {
        if ($oldPath === $newPath) return;

        $newDest = public_path($newPath);

        if (!file_exists($newDest)) {
            mkdir($newDest, 0755, true);
        }

        /** Solo las imágenes de este producto */
        $images = ProductsImage::where('product_id', $product->id)->get();

        foreach ($images as $image) {
            $filename    = basename($image->path);
            $source      = public_path("{$oldPath}/{$filename}");
            $destination = "{$newDest}/{$filename}";

            if (file_exists($source)) {
                rename($source, $destination);
            }
        }

        /** Update de los registros de base de datos */
        ProductsImage::where('product_id', $product->id)
            ->update([
                'path' => DB::raw("REPLACE(path, '$oldPath', '$newPath')"),
            ]);
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


    /** Funciones Helpers */

    /**
     * Construir ruta
     * @param $cat category
     * @param $sub  subcategory
     */
    public function makePath(int $cat, int $sub): string
    {
        /** Unimos categoria y subcategoria principal  */
        $parent = Category::findOrFail($cat);
        $children = Category::findOrFail($sub);

        return $parent->name . '/' . $children->name;
    }

    /**
     * Saber ruta actual
     * @params $productID
     */
    public function currentPath(int $productID): ?string
    {
        $image = ProductsImage::where('product_id', $productID)->first();

        if (!$image) return null;

        /** deconstruirmos ruta de la ruta de BD */
        return implode('/', array_slice(explode('/', $image->path), 0, 2));
    }
}
