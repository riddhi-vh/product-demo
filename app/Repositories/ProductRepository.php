<?php 
namespace App\Repositories;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Helpers\Utility;

class ProductRepository implements ProductRepositoryInterface{

    public function getData($columnName, $columnSortOrder, $searchValue, $start, $rowperpage)
    {
        \DB::enableQueryLog(); // Enable query log
        info($searchValue);
        if ($columnName == 'id') {
            $columnSortOrder = $columnSortOrder == 'asc' ? 'desc' : 'asc';
        }
        $query = Product::orderBy($columnName, $columnSortOrder);

        if ($searchValue != null) {
            $query->where('p_name', 'like', '%' . $searchValue . '%');
            $query->orwhere('p_code', '=', $searchValue);
        }
        $query->skip($start);
        $query->take($rowperpage);
        $query->get();
        

// Your Eloquent query executed by using get()

info(\DB::getQueryLog()); // Show results of log
return $query->get();
    }

    public function countData($search =''){
        $query = Product::query();
        if($search != ''){
            $query = $query->where('p_name', 'like', '%' . $search . '%');
        }
        $count = $query->count();
        return $count;
    }

    public function getFindData($id){
        $query = Product::find($id);
        return $query;
    }

    public function updateData($id, $reqData){
        $product = Product::find($id);
        $reqData['updated_at'] = Utility::currentdate();
        $product->update($reqData);
        return $this->getFindData($id);
    }

    public function storeData($reqData){
        return Product::create($reqData);
    }

    public function deleteData($id){
        return Product::where('id',$id)->delete();
    }
}

?>