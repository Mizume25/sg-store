<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ImageService
{
    /**
     * @param UploadedFile $img 
     * @param Product $product
     */
    public function upload(?UploadedFile $img, Product $product): void
    {
        if ($img == null) return;

        $path  = $this->makePath($product);

        /** Apuntamos carpeta destino */
        $dest = public_path($path);

        /** En caso de que no exista crearemos el directorio */
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        /** Nombre único */
        $name = uniqid() . '.' . $img->getClientOriginalExtension();

        /** Ponemos las imagenes */
        $img->move($dest, $name);

        $this->store($path, $name, $product->id);
    }

    /**
     * 
     * @param string $path
     * @param string $name
     * @param int $id
     */
    private function store(string $path, string $name, int $id)
    {
        ProductsImage::create([
            'path' => $path . '/' . $name,
            'product_id' => $id
        ]);
    }


    public function delete(int $id): void
    {
        $img = ProductsImage::find($id);

        if (file_exists(public_path($img->path))) {
            unlink(public_path($img->path));
        }

        $img->delete();
    }

    /** Funcion para reorganizar carpetas en caso de upadtes a subcategories */
    public function reorganize(Product $product, string $oldPath): void
    {
        $newPath = $this->makePath($product); 
        $newDest = public_path($newPath);    

        if ($oldPath === $newPath) return;

        if (!file_exists($newDest)) {
            mkdir($newDest, 0755, true);
        }

        // Mover archivos
        foreach (array_diff(scandir(public_path($oldPath)), ['.', '..']) as $file) {
            rename(
                public_path($oldPath . '/' . $file),
                $newDest . '/' . $file
            );
        }

        // Actualizar rutas en BD (relativas)
        ProductsImage::where('product_id', $product->id)
            ->update([
                'path' => DB::raw("REPLACE(path, '$oldPath', '$newPath')"),
            ]);
    }

    public function replace(int $id, UploadedFile $new, Product $product): void
    {
        $this->delete($id);

        $this->upload($new, $product);
    }

    /** Funcion que construye la ruta */
    public function makePath(Product $product): string
    {
        /**Construiremos el path */
        $parent = $product->categories->first();
        $sub = $product->categories->where('parent_id', '!=', null)->first();

        return $parent->name . '/' . $sub->name;
    }
}
