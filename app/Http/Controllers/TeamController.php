<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Workspace_User;
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
    return view("TeamInviteComfirm", compact('token'));
}

public function confirm_post(Request $request)
{
    Workspace_User::where("token", $request->token)
    ->update(["status" => '1']);

    return redirect()->route('login')->with('success', 'You are in the team now!!!');
}




}
