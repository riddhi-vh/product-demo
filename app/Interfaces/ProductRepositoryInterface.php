<?php 
namespace App\Interfaces;

interface ProductRepositoryInterface{

    public function getData($columnName, $columnSortOrder, $searchValue, $start, $rowperpage);
    public function countData($search);
    public function getFindData($id);
    public function deleteData($id);
}

?>