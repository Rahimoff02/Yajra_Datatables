<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\staff;
use Datatables;

class staffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(staff::select('*')->where('user_id','=',Auth::id()))
            ->addColumn('image', 'image')
            ->rawColumns(['action','image'])
            ->addColumn('created_at',function($row){
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })
            ->addColumn('action',function ($row){

                    return '
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm">
                        Edit
                    </a>
                    <a href="javascript:void(0);" id="delete" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger btn-sm">
                        Delete
                    </a>';
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('staff-list');
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

        $con = new staff();

        $yoxla = $con->where('email','=',$request->email)->where('id','!=',$request->id)->where('user_id','=',Auth::id())->orwhere('phone','=',$request->phone)->where('id','!=',$request->id)->where('user_id','=',Auth::id())->count();

        if($yoxla==0){

        if($bookId){
             
            $book = staff::find($bookId);

            if($request->hasFile('image')){
                $path = $request->file('image')->store('public/images');
                $book->image = $path;
            }   
         }else{
                $path = $request->file('image')->store('public/images');
               $book = new staff();
               $book->image = $path;
         }
         
        $book->name = $request->name;
        $book->surname = $request->surname;
        $book->email = $request->email;
        $book->phone = $request->phone;
        $book->hired = $request->hired;
        $book->salary = $request->salary;
        $book->job = $request->job;
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
        $book  = staff::where($where)->first();
     
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
        $book = staff::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }

}