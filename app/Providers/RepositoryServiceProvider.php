<?php 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\PackageRepositoryInterface;
use App\Interfaces\ProductImageRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductimageRepository;
use App\Repositories\PackageRepository;

Class RepositoryServiceProvider extends ServiceProvider{

    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        $this->app->bind(ProductRepositoryInterface::class, function ($app) {
            return $app->make(ProductRepository::class);
        });
        $this->app->bind(PackageRepositoryInterface::class, function ($app) {
            return $app->make(PackageRepository::class);
        });
        $this->app->bind(ProductImageRepositoryInterface::class, function($app){
            return $app->make(ProductImageRepository::class);
        });
    }

     /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

}

?>