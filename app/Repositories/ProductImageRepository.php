<?php 
namespace App\Repositories;
use App\Interfaces\ProductImageRepositoryInterface;
use App\Models\ProductImage;
use App\Http\Traits\ImageUploadTrait;


class ProductImageRepository implements ProductImageRepositoryInterface{

    use ImageUploadTrait;

    public function getFindData($id)
    {
        $query = ProductImage::where('p_id',$id);
        return $query->get();
    }

    public function storeImages($reqData){
        foreach($reqData['file'] as $file){
            $filename = $this->storeImage($file, 'images');
            ProductImage::create([
                    'p_id' => $reqData['id'],
                    'p_image' => $filename
                ]);
        }
        return true;
    }

    public function deleteImage($id){
       
        $data = ProductImage::where('id',$id)->delete();
  
        // dd($data['p_image']);
       // if (isset($data['p_image']) && $data['p_image'] != ''  && $data['p_image'] != null) {
            // $this->deleteImage($data['p_image'], 'images');
       // }
        // ($data->delete());
        return $data;
    }
}

?>