<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Package;
use App\Helpers\Utility;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trimmedName = Utility::currentdate();
        $products = Product::get();
        foreach($products as $key => $pro){
            $products[$key]->quantity = $pro->p_quantity;
            if($pro->p_package == 'GM'){
                $products[$key]->quantity = $pro->p_quantity / 1000 ;   
            }else if($pro->p_package == 'ML'){
                $products[$key]->quantity = $pro->p_quantity / 1000000;
            }
        }
        return view('product.product_list',['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = Package::get();
        return view('product.product_save',['packages' => $package]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $post = $request->all();
        /* Check mode of request if it is add mode, insert record otherwise uypdate record.  */
        if(isset($post['mode']) && $post['mode'] == 'create'){
            // Call validation rule
            $this->productValidationRule($request,0);

            $model = new Product();
            $model->created_at = Utility::currentdate();
        }else if(isset($post['mode']) && $post['mode'] == 'edit'){
            $id = $request['id'];
            // Call validation rule
            $this->productValidationRule($request,$id);

            $model = Product::find($id);
            $model->updated_at = Utility::currentdate();
            // Remove old images in case the images are removed.
            if(isset($request->oldimages) && !empty($request->oldimages)){
                $eximage = explode(',',$request->oldimages);
                foreach($eximage as $eximg){
                    ProductImage::where('id',$eximg)->delete();
                }
            }
        }

        $model->p_name = $request->input('p_name');
        $model->p_code = $request->input('p_code');
        $model->p_package = $request->input('p_package');
        $model->p_quantity = $request->input('p_quantity');
        $model->p_description = $request->input('p_description');
        $model->save();

        if(isset($post['file'])  && !empty($post['file'])){
            foreach($post['file'] as $file){
                $filename = $file->store('public/images');
                ProductImage::create([
                    'p_id' => $model->id,
                    'p_image' => $filename
                ]);
            } 
        }
        return redirect()->route('product-list')->with('message', 'Product saved successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mode = 'edit';
        $product = Product::find($id);
        $productImages = ProductImage::where('p_id',$id)->get();
        $package = Package::get();
        return view('product.product_save',['mode' => $mode,'product' => $product,'productImages'=> $productImages,'packages' => $package]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
        }
        return redirect()->route('product-list')->with('message', 'Product deleted successfully!');
    }

    public function productValidationRule($request,$id){

        if($id > 0){
            $rules = [
                'p_name' => ['required', 'string', 'max:255'],
                'p_code' => ['required', 'string', 'max:255', 'unique:product,p_code,'.$id],
                'p_package'=> ['required'],
                'p_quantity'=> ['required','numeric'],
                'p_description'=> ['required'],
            ];
        }else{
            $rules = [
                'p_name' => ['required', 'string', 'max:255'],
                'p_code' => ['required', 'string', 'max:255', 'unique:product'],
                'p_package'=> ['required'],
                'p_quantity'=> ['required','numeric'],
                'p_description'=> ['required'],
            ];
        }
        
        // Custom show messages
        $customMessages = [
            'p_name.required' => 'The product name field is required.',
            'p_name.max' => 'The product name is not valid.',
            'p_name.string' => 'The product name is not valid.',
            'p_code.required' => 'The product code field is required.',
            'p_code.max' => 'The product name is not valid.',
            'p_code.string' => 'The product name is not valid.',
            'p_code.unique' => 'The product code is already in used.',
            'p_package.required' => 'The product package field is required.',
            'p_description.required' => 'The product description field is required.',
            'p_quantity.required' => 'The product quantity field is required.',
            'p_quantity.numeric' => 'The product quantity is not valid.'
        ];
    
        return $this->validate($request, $rules, $customMessages);
    }
}
