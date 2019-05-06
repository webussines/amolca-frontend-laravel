<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Specialties;
use App\Repositories\Posts;
use App\Repositories\Authors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminSpecialtiesController extends Controller
{

    protected $specialties;
    protected $posts;
    protected $authors;
    protected $request;

    public function __construct(Specialties $specialties, Posts $posts, Request $request, Authors $authors) {

        $this->middleware('superadmin', [ 'except' => [ 'all' ] ]);

        $this->request = $request;
        $this->specialties = $specialties;
        $this->posts = $posts;
        $this->authors = $authors;
    }

    public function all() {

        $limit = (Input::post('limit')) ? Input::post('limit') : '10000';
        $skip = (Input::post('skip')) ? Input::post('skip') : '0';
        $inventory = (Input::post('inventory')) ? Input::post('inventory') : 0;
        $params = "orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $resp = [];

        $resp['data'] = $this->specialties->all($params)->taxonomies;

        return $resp;

    }

    public function index()
    {
        $params = "orderby=title&order=1&limit=100&skip=0";
        $specialties = $this->specialties->all($params);

        return view('admin.specialties.index', ['specialties' => $specialties]);
    }

    // Return all books in json response
    public function get_books($id) {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $inventory = (Input::get('inventory')) ? Input::get('inventory') : 0 ;
        $params = "type=book&orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $books = $this->posts->taxonomies($id, $params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $books->posts;

            return $resp;
        }

        return Response::json($books->posts);
    }

    // Books page
    public function books($id) {

        $page_type = 'specialties';
        $specialty = $this->specialties->findById($id);

        if( !isset($specialty->title) ) {
            return redirect('/am-admin/especialidades');
        }

        return view('admin.books.index', [ 'page_type' => $page_type, 'specialty' => $specialty ]);

    }

    // Show book inventory
    public function show_book($id, $book) {

        $authors = $this->authors->all();
        $specialties = $this->specialties->all();
        $book = $this->specialties->book($id, $book);

        if($book->post->type == 'post') {

            return redirect('/am-admin/blog/' . $book->post->id);

        } else if($book->post->type == 'event') {

            return redirect('/am-admin/eventos/' . $book->post->id);

        }

        $send_info = [];

        $send_info['specialties'] = $specialties->taxonomies;
        $send_info['authors'] = $authors->posts;
        $send_info['action'] = 'edit';

        $send_info['book'] = $book->post;
        $send_info['specialty_active'] = $id;

        if(isset($book->prev)) {
            $send_info['prev'] = $book->prev;
        }

        if(isset($book->next)) {
            $send_info['next'] = $book->next;
        }

        return view('admin.books.single', $send_info);
    }

    public function show($id)
    {
        $specialties = $this->specialties->all();
        $specialty = $this->specialties->findById($id);

        return view('admin.specialties.single', [
            'specialty' => $specialty,
            'specialties' => $specialties,
            'action' => 'edit'
        ]);
    }

    public function edit($id)
    {
        $update = Input::post('update');
        return $this->specialties->updateById($id, $update);
    }

    public function create()
    {
        return view('admin.specialties.single', [
            'action' => 'create'
        ]);
    }

    public function store(Request $request)
    {
        $specialty = Input::post('body');
        return $this->specialties->create($specialty);
    }

    public function destroy($id)
    {
        return $this->specialties->deleteById($id);
    }
}
