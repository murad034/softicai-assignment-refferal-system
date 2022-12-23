<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function displayWelcome(){
        return view('welcomeAdmin');
    }

}
