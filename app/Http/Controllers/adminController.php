< ? php

namespace App\ Http\ Controllers;

use Illuminate\ Http\ Request;
use App\ Http\ Requests\ userRequest;
use Illuminate\ Support\ Facades\ Auth;
use Illuminate\ Support\ Facades\ Hash;
use App\ Models\ User;

use Datatables;

class adminController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function index() {
        if (request() - > ajax()) {
            return datatables() - > of (User::select('*') - > where('id', '!=', Auth::id())) -
                > addColumn('created_at', function ($row) {
                    return date('Y-m-d H:i:s', strtotime($row - > created_at));
                }) -
                > addColumn('action', function ($row) {

                    if ($row - > blok == 0) {
                        return ' <
                            a href = "javascript:void(0)"
                        data - toggle = "tooltip"
                        data - id = "'.$row->id.'"
                        data - original - title = "Edit"
                        class = "edit btn btn-warning btn-sm" >
                            Edit <
                            /a> <
                            a href = "javascript:void(0);"
                        id = "delete"
                        data - id = "'.$row->id.'"
                        data - toggle = "tooltip"
                        data - original - title = "Delete"
                        class = "delete btn btn-danger btn-sm" >
                            Delete <
                            /a> <
                            a href = "javascript:void(0);"
                        id = "blok"
                        data - id = "'.$row->id.'"
                        data - toggle = "tooltip"
                        data - original - title = "Blok"
                        class = "blok btn btn-success btn-sm" >
                            Block <
                            /a>';
                    } else {
                        return ' <
                            a href = "javascript:void(0);"
                        id = "unblok"
                        data - id = "'.$row->id.'"
                        data - toggle = "tooltip"
                        data - original - title = "Unblok"
                        class = "unblok btn btn-success btn-sm" >
                            Unblock <
                            /a>';
                    }

                }) -
                > addIndexColumn() -
                > make(true);
        }
        return view('admin-list');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request) {
        $bookId = $request - > id;

        $yoxla = User::where('email', '=', $request - > email) - > where('id', '!=', $request - > id) - > orwhere('phone', '=', $request - > phone) - > where('id', '!=', $request - > id) - > count();

        if ($yoxla == 0) {

            if ($bookId) {
                $book = User::find($bookId);
            } else {
                $book = new User();
            }

            $book - > name = $request - > name;
            $book - > surname = $request - > surname;
            $book - > email = $request - > email;
            $book - > phone = $request - > phone;
            $book - > blok = 0;

            $book - > password = Hash::make($request - > password);

            $book - > save();

            return Response() - > json($book);
        }
        return Response() - > json($yoxla);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Request $request) {
        $where = array('id' => $request - > id);
        $book = User::where($where) - > first();

        return Response() - > json($book);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Request $request) {
        $book = User::where('id', $request - > id) - > delete();

        return Response() - > json($book);
    }

    public
    function blok(Request $post) {

        $blok = User::find($post - > id);

        $blok - > blok = 1;

        $blok - > save();

        {
            $blok = 'User blocked succesfully.';
        }

        return Response() - > json($blok);

    }

    public
    function unblok(Request $post) {

        $noblok = User::find($post - > id);

        $noblok - > blok = 0;

        $noblok - > save();

        {
            $noblok = 'User unblocked succesfully.';
        }

        return Response() - > json($noblok);

    }

}
