<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Workspace_User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    //
 // TeamController.php

public function invitaion_post(Request $request, $id)
{
    $selectedWorkspace = Workspace::findOrFail($id); // Retrieve the workspace

    $request->validate([
        'email' => "required|email|exists:users",
    ]);

    $token = Str::random(64);

    $InviteUser = User::where('email', $request->email)->firstOrFail(); // Retrieve the user

    $workspace_user = new Workspace_User;
    $workspace_user->user_id = $InviteUser->id;
    $workspace_user->workspace_id =$selectedWorkspace->id;
    $workspace_user->token = $token;
    $workspace_user->status ='0';
    $workspace_user->save();

    // Pass data to the view

    Mail::send("emails.invitation-sending", ['token' => $token], function ($message) use ($request) {
        $message->to($request->email);
        $message->subject("Team Invitation");
    });

    return redirect()->back()->with('success', 'Your invitation has been sent.');
}

public function viewteam_invite($token) {
    // Find the Workspace_User record with the provided token
    $workspace_user = Workspace_User::where('token', $token)->first();

    // Check if the record was found
    if ($workspace_user) {
        // If the record was found, retrieve the workspace_id
        $workspace_id = $workspace_user->workspace_id;
        
        // Find the Workspace record with the retrieved workspace_id
        $workspace = Workspace::find($workspace_id);
        
        // Check if the Workspace record was found
        if ($workspace) {
            // If both records are found, pass the data to the view
            return view("TeamInviteComfirm", ['workspace' => $workspace, 'token' => $token]);
        } else {
            // If the Workspace record was not found, handle the error (e.g., redirect or display an error message)
            return redirect()->route('errorPage')->with('error', 'Workspace not found.');
        }
    } else {
        // If the Workspace_User record was not found, handle the error (e.g., redirect or display an error message)
        return redirect()->route('errorPage')->with('error', 'Workspace_User record not found.');
    }
}


public function confirm_post(Request $request)
{
    Workspace_User::where("token", $request->token)
    ->update(["status" => '1']);

    return redirect()->route('login')->with('success', 'You are in the team now!!!');
}

public function remove_user(Request $request,$id){
    DB::table("workspace__users")->where('id',$id)->delete();
    return redirect()->back()->with('success', 'You have kick your Friends Successfully.');

  }
}
