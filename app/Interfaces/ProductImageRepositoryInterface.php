<?php 
namespace App\Interfaces;

interface ProductImageRepositoryInterface{

    public function getFindData($id);
    public function storeImages($reqData);
    public function deleteImage($id);
}

?>