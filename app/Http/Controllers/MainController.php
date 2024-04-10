<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Workspace_User;

class MainController extends Controller
{
    public function index()
    {
        $data['workspaces'] = Workspace::get()->all();
        $data['Worksapce_User'] = Workspace_User::get()->all();
        $data['User'] = auth()->user();
        return view('home', $data);
    }


}


