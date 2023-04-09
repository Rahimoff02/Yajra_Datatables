<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\brands;
use App\Models\orders;
use Datatables;
use Illuminate\Support\Facades\Auth;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(products::join('brands','brands.id','=','products.brand_id')
            ->select('products.image','products.id','products.alis','products.satis','products.stok','products.mehsul','brands.brend','products.created_at')
            ->orderBy('products.id','desc')
            ->where('products.user_id','=',Auth::id())
            ->get())
            ->addColumn('image', 'image')
            ->rawColumns(['action','image'])
            ->addColumn('created_at',function($row){
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })
            ->addColumn('action',function ($row){

                    return '
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-lg">
                        Edit
                    </a>
                    <a href="javascript:void(0);" id="delete" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete"  class="delete btn btn-danger btn-lg">
                        Delete
                    </a>';
            })
            ->addIndexColumn()
            ->make(true);
        }
        
        
        $bdata = brands::where('user_id','=',Auth::id())->orderBy('id','desc')->get();

         return view('products-list',[
                'bdata'=>$bdata
            ]);
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $bookId = $request->id;

        if($bookId){
             
            $book = products::find($bookId);

            if($request->hasFile('image')){
                $path = $request->file('image')->store('public/images');
                $book->image = $path;
            }   
         }else{
                $path = $request->file('image')->store('public/images');
               $book = new products();
               $book->image = $path;
         }
         
        $book->brand_id = $request->brand_id;
        $book->mehsul = $request->mehsul;
        $book->alis = $request->alis;
        $book->satis = $request->satis;
        $book->stok = $request->stok;     

        $book->user_id = Auth::id();
        
        $book->save();
     
        return Response()->json($book);
    }
     
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $book  = products::where($where)->first();
     
        return Response()->json($book);
    }
     
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $yoxla = orders::where('product_id','=',$request->id)
        ->where('user_id','=',Auth::id())
        ->count();

        if($yoxla==0){
          
        $book = products::where('id',$request->id)->delete();

        {$book = 'Product deleted succesfully.';}
     
        }
        else
        {$book = "This product exist in order's table.";}
        
        return Response()->json($book);
    }

} 