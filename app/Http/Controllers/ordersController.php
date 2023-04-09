<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\clients;
use App\Models\products;
use App\Models\brands;

use Datatables;
use Illuminate\Support\Facades\Auth;

class ordersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(orders::join('clients','clients.id','=','orders.client_id') 
            ->join('products','products.id','=','orders.product_id')
            ->join('brands','brands.id','=','products.brand_id')
            ->select('brands.brend','clients.ad','products.alis','products.satis','clients.soyad','products.stok','products.mehsul','orders.created_at','orders.id','orders.miqdar','orders.tesdiq','orders.user_id')
            ->orderBy('orders.id','desc')
            ->where('orders.user_id','=',Auth::id())
            ->get())     
            ->addColumn('created_at',function($row){
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })
            ->addColumn('action',function ($row){

                if($row->tesdiq==0)
                {
                    return '
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Redakte" class="Edit btn btn-warning btn-sm">
                        Edit
                    </a>
                    <a href="javascript:void(0);" id="delete" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete" class="Delete btn btn-danger btn-sm">
                        Delete
                    </a>
                    <a href="javascript:void(0);" id="tesdiq" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Accept" class="Accept btn btn-success btn-sm">
                        Accept
                    </a>';
                }
                else
                {
                    return'
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Levg" class="Cancel btn btn-danger btn-sm">
                        Cancel
                    </a>';
                }
            })
            ->addIndexColumn()
            ->make(true);
        }
        
        $bdata = brands::where('user_id','=',Auth::id())->get();
        $cdata = clients::where('user_id','=',Auth::id())->get();

        $pdata = products::join('brands','brands.id','=','products.brand_id')
        ->select('brands.brend','products.id','products.stok','products.mehsul','products.alis','products.satis','products.user_id')
        ->orderBy('products.id','desc')
        ->where('products.user_id','=',Auth::id())
        ->get();

         return view('orders-list',[
                'bdata'=>$bdata,
                'cdata'=>$cdata,
                'pdata'=>$pdata
                
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

        if($bookId)
        {$book = orders::find($bookId);}
         else
        {$book = new orders();}

        $book->client_id = $request->client_id;
        $book->product_id = $request->product_id;   
        $book->miqdar = $request->miqdar;
        $book->tesdiq = 0;
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
        $book  = orders::where($where)->first();
     
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
        $book = orders::where('id',$request->id)->delete();

        {$book = 'Order deleted succesfully.';}
     
        return Response()->json($book);
    }

    public function tesdiq(Request $request){

        $orders = orders::find($request->id);
    
        $omiq = $orders->miqdar;

        $products = products::find($orders->product_id);

        $pmiq = $products->stok;

            if($omiq < $pmiq)
            {
                $miq=$pmiq-$omiq;

                $products->stok = $miq;

                $products->save();

                $orders->tesdiq = 1;

                $orders->save();             
            }
            else
            {$orders = "You don't have enough products to accept this order.";}

            return Response()->json($orders);
    }


    public function levg(Request $request){
        
        $orders = orders::find($request->id);
    
        $omiq = $orders->miqdar;
    
        $products = products::find($orders->product_id);
    
        $pmiq = $products->stok;

          $miq = $pmiq + $omiq ;
    
              $products->stok = $miq ;
    
                $products->save();
    
                $orders->tesdiq = 0;
    
                $orders->save();

                {$orders = 'Order canceled succesfully.';}
    
        return Response()->json($orders);
            
    }

}