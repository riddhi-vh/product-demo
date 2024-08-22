<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\PackageRepositoryInterface;
use App\Interfaces\ProductImageRepositoryInterface;
use App\Http\Requests\ProductRequest;
use Exception;

class ProductController extends Controller
{
    protected $productRepository = "";
    protected $packageRepository = "";
    protected $productImageRepository = "";
    public function __construct(ProductRepositoryInterface $productRepository, PackageRepositoryInterface $packageRepository, ProductImageRepositoryInterface $productImageRepository)
    {
        $this->productRepository = $productRepository;
        $this->packageRepository = $packageRepository;
        $this->productImageRepository = $productImageRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('product.product_list');
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");

        $columnIndexArray = $request->get('order');
        $columnNameArray = $request->get('columns');
        $orderArray = $request->get('order');
        $searchArray = $request->get('search');

        $columnIndex = $columnIndexArray[0]['column'];
        $columnName = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue = $searchArray;

        $totalRecords = $this->productRepository->countData();
        $rowPerPage = $request->length == '-1' ? $totalRecords : $request->length;
        
        $totalRecordswithFilter = $this->productRepository->countData($searchValue);
        
        $records = $this->productRepository->getData($columnName, $columnSortOrder, $searchValue, $start, $rowPerPage);
        $dataArray = array();
        $start += 1;
        foreach ($records as $record) {
            $id = $record->id;
            $action = '';
            $action .= '<div style="float:right;"><a href="' . route('products.edit', $id) . '" title="Edit" class="navi-link" style="margin-right: 7px;">
                                       <span class="navi-icon">
                                           <i class="fa fa-edit text-primary" style="font-size:1.5rem;"></i>
                                       </span>
                                   </a>';

            $action .= ' <a href="javascript:void(0);" data-route="'.route("products.destroy",$id).'" data-id="' . $id . '" class="navi-link delToolType deleteProduct" title="Delete">
                                   <span class="navi-icon">
                                       <i class="fa fa-trash text-danger" style="font-size:1.5rem;"></i>
                                   </span>
                               </a> </div>';
            $quantity = $record->p_quantity;
            if($record->p_package == 'GM'){
                $quantity = $record->p_quantity / 1000 ;   
            }else if($record->p_package == 'ML'){
                $quantity = $record->p_quantity / 1000000;
            }
            $dataArray[] = array(
                "id" => $start,
                "p_code" => $record->p_code,
                "p_name" => $record->p_name,
                "p_package" => $record->p_package,
                "p_quantity" => $quantity,
                "action" => $action,
            );
            $start++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $dataArray,
        );
        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = $this->packageRepository->getAllData();
        return view('product.product_save',['packages' => $package]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $reqData = $request->all();
            if (isset($request->id) && $request->id != null && $request->id > 0) {
                $data = $this->productRepository->updateData($request->id, $reqData);
                $msg = 'messages.custom.update_messages';
            } else {
                $data = $this->productRepository->storeData($reqData);
                $reqData['id'] = $data->id;
                $msg = 'messages.custom.create_messages';
            }
            if(isset($reqData['file'])  && !empty($reqData['file'])){
                $this->productImageRepository->storeImages($reqData);
            }
            if(isset($reqData['oldimages']) && !empty($reqData['oldimages'])){
                $eximage = explode(',',$reqData['oldimages']);
                foreach($eximage as $eximg){
                    $this->productImageRepository->deleteImage($eximg);
                }
            }
            DB::commit();
            return redirect()->route('products.index')->with('message', trans($msg,["attribute" => "Product"]));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('products.index')->with('message', 'Product not saved. Something went to wrong !');
        }
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
        $product = $this->productRepository->getFindData($id);
        $productImages = $this->productImageRepository->getFindData($id);
        $package = $this->packageRepository->getAllData();
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
        try{
            $this->productRepository->deleteData($id);
            return $this->sendResponse(true, ['data' => []], trans(
                'messages.custom.delete_messages',
                ["attribute" => "Product"]
            ));
        }catch(Exception $e){
            return redirect()->route('products.index')->with('message', trans('message.custom.something_wrong')); 
        }
    }
}
