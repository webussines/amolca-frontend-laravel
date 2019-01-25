<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Forms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class FormsController extends Controller
{
    
    protected $request;
    protected $response;
    protected $forms;

    public function __construct(Response $response, Request $request, Forms $forms) {
        $this->request = $request;
        $this->response = $response;
        $this->forms = $forms;
    }

    public function send()
    {

        $request = $this->request->all();

        $cc = mailer_get_cc();
        $me = mailer_get_me();
        $domain = mailer_get_domain();

        $request['to'] = $me;
        $request['cc'] = $cc;
        $request['domain'] = $domain;

        $resp = $this->forms->create($request);

        return $resp;
    }
}
