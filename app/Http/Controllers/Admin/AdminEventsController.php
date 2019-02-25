<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminEventsController extends Controller
{

    protected $events;
    protected $request;
    protected $response;

    public function __construct(Posts $events, Request $request, Response $response) {

        $this->middleware('superadmin');

        $this->events = $events;
        $this->request = $request;
        $this->response = $response;
    }

    //return all books for ajax requests
    public function all() {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $inventory = (Input::get('inventory')) ? Input::get('inventory') : 0 ;
        $params = "orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $events = $this->events->all("event", $params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $events->posts;

            return $resp;
        }

        return Response::json($events->posts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $send_info = [];
        $send_info['action'] = 'create';

        return view('admin.events.single', $send_info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = $request->post('body');
        return $this->events->create($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->events->inventory($id, "event");

        if($post->post->type == 'post') {

            return redirect('/am-admin/blog/' . $post->post->id);

        } else if($post->post->type == 'book') {

            return redirect('/am-admin/libros/' . $post->post->id);
            
        }

        $send_info = [];
        $send_info['action'] = 'edit';

        $send_info['post'] = $post->post;

        if(isset($post->prev)) {
            $send_info['prev'] = $post->prev;
        }

        if(isset($post->next)) {
            $send_info['next'] = $post->next;
        }

        return view('admin.events.single', $send_info);
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
        return $this->events->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->events->deleteById($id);
    }
}
