<?php 
namespace App\Repositories;
use App\Interfaces\PackageRepositoryInterface;
use App\Models\Package;

class PackageRepository implements PackageRepositoryInterface{

    public function getAllData()
    {
        $query = Package::orderBy('id', 'desc');
        return $query->get();
    }
}

?>