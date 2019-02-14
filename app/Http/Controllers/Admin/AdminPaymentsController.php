<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPaymentsController extends Controller
{
    
	public function index() {
		return view('admin.payments.index');
	}

	public function tucompra() {
		return view('admin.payments.methods.tucompra');
	}

	public function paypal() {
		return view('admin.payments.methods.paypal');
	}

}
