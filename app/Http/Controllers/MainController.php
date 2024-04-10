<?php

namespace App\Http\Controllers;

use App\Models\activityLog;
use App\Models\recentlyLog;
use Illuminate\Http\Request;
use App\Models\Workspace;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index() {
        $data['workspaces'] = Workspace::get()->all();
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50 ) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }
        
        return view('home', $data, $datarecently);
    }
    public function activityLogInLogOut() {
        $data['workspaces'] = Workspace::get()->all();
        $activityLog['user_activity'] = activityLog::get()->all();
        return view('activity_log', $data,$activityLog);
    }
}


