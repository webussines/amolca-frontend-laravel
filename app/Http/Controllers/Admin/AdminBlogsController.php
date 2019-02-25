<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminBlogsController extends Controller
{

    protected $blog;
    protected $request;
    protected $response;

    public function __construct(Posts $blog, Request $request, Response $response) {

        $this->middleware('superadmin');

        $this->blog = $blog;
        $this->request = $request;
        $this->response = $response;
    }

    //return all books for ajax requests
    public function all() {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $inventory = (Input::get('inventory')) ? Input::get('inventory') : 0 ;
        $params = "orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $blog = $this->blog->all("post", $params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $blog->posts;

            return $resp;
        }

        return Response::json($blog->posts);
    }

    /*Return all blog posts*/
    public function index()
    {
        $params = "orderby=title&order=1&limit=1&skip=0";
        $posts = $this->blog->all('post', $params);

        return view('admin.blog.index', ['posts' => $posts->posts]);
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

        return view('admin.blog.single', $send_info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->post('body');
        return $this->blog->create($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->blog->inventory($id, "post");

        if($post->post->type == 'event') {

            return redirect('/am-admin/eventos/' . $post->post->id);

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

        return view('admin.blog.single', $send_info);
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
        return $this->blog->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->blog->deleteById($id);
    }
}
