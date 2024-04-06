<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;

class MainController extends Controller
{
    public function index() {
        $data['workspaces'] = Workspace::get()->all();
        return view('home', $data);
    }


}


