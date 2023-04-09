<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\expense;

use Datatables;

class expenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(expense::select('*')->where('user_id','=',Auth::id()))
            ->addColumn('created_at',function($row){
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })
            ->addColumn('action',function ($row){

                    return '
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm">
                        Edit
                    </a>
                    <a href="javascript:void(0);" id="delete" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete"  class="delete btn btn-danger btn-sm">
                        Delete
                    </a>';
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('expense-list');
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
        {$book = expense::find($bookId);}
         else
        {$book = new expense();}
         
        $book->teyinat = $request->teyinat;
        $book->mebleg = $request->mebleg;
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
        $book  = expense::where($where)->first();
     
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
        $book = expense::where('id',$request->id)->delete();
     
        {$book = 'Appointment deleted succesfully.';}
        return Response()->json($book);
    }

}