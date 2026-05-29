<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ImageService
{
    /**
     * @param UploadedFile $img 
     * @param string $path
     * @param int $productId
     */
    public function upload(?UploadedFile $img, string $path, int $productId): void
    {
        if ($img == null) return;

        $dest = public_path($path);

        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        $name = uniqid() . '.' . $img->getClientOriginalExtension();
        $img->move($dest, $name);

        $this->store($path, $name, $productId);
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


    public function remove(int $productId): void
    {
        $images = ProductsImage::where('product_id', $productId)->get();

        foreach ($images as $image) {
            if (file_exists(public_path($image->path))) {
                unlink(public_path($image->path));
            }
            $image->delete();
        }
    }

    /** Funcion para reorganizar carpetas en caso de upadtes a subcategories */
    public function reorganize(Product $product, string $oldPath, string $newPath): void
    {
        if ($oldPath === $newPath) return;

        $newDest = public_path($newPath);

        if (!file_exists($newDest)) {
            mkdir($newDest, 0755, true);
        }

        foreach (array_diff(scandir(public_path($oldPath)), ['.', '..']) as $file) {
            rename(
                public_path($oldPath . '/' . $file),
                $newDest . '/' . $file
            );
        }

        ProductsImage::where('product_id', $product->id)
            ->update([
                'path' => DB::raw("REPLACE(path, '$oldPath', '$newPath')"),
            ]);
    }

    public function replace(int $id, UploadedFile $new, string $path, int $productId): void
    {
        $this->delete($id);
        $this->upload($new, $path, $productId);
    }

    public function makePath(int $cat, int $sub): string
    {
        $parent = Category::findOrFail($cat);
        $children = Category::findOrFail($sub);

        return $parent->name . '/' . $children->name;
    }
}
