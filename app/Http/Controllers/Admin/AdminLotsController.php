<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Lots;
use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminLotsController extends Controller
{

    protected $lots;
    protected $posts;
    protected $request;
    protected $response;

    public function __construct(Request $request, Posts $posts, Lots $lots, Response $response) {
        $this->posts = $posts;
        $this->lots = $lots;
        $this->request = $request;
        $this->response = $response;
    }

    public function all() {

        $lots = $this->lots->all();

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $lots;

            return $resp;
        }

        return Response::json($lots->posts);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lots.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $books = $this->posts->list('book')->posts;

        return view('admin.lots.single', [ 'action' => 'create', 'all_books' => $books ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lot = $request->post('body');
        return $this->lots->create($lot);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $lot = $this->lots->findById($id);
        $books = $this->posts->list('book')->posts;

        return view('admin.lots.single', [ "lot" => $lot, "action" => "edit", "all_books" => $books ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $body = Input::post('body');
        return $this->lots->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->lots->deleteById($id);
    }
}
