<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\brands;
use App\Models\products;

use Datatables;

class brandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(brands::select('*')
            ->where('user_id','=',Auth::id()))
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
        return view('brands-list');
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
        $yoxla = brands::where('brend','=',$request->brend)->where('user_id','=',Auth::id())->count();

        if($yoxla==0){

        if($bookId){           
            $book = brands::find($bookId);
            if($request->hasFile('image')){
                $path = $request->file('image')->store('public/images');
                $book->image = $path;
            }   
         }else{
            $path = $request->file('image')->store('public/images');
               $book = new brands;
               $book->image = $path;

         }
        
        $book->brend = $request->brend;
        $book->user_id = Auth::id();
        $book->save();
     
        return Response()->json($book);
    }

    return Response()->json($yoxla);
     
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
        $book  = brands::where($where)->first();
     
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
        $yoxla = products::where('brand_id','=',$request->id)
        ->where('user_id','=',Auth::id())
        ->count();

        if($yoxla==0){

        $book = brands::where('id',$request->id)->delete(); 
        
        {$book ='Brand deleted succesfully.';}
        }    
        else
        {$book ="This brand already exist in brand's table.";}

        return Response()->json($book);
    }

}