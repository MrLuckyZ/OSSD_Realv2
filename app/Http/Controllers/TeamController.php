<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    //
    public function invitaion_post(Request $request , $id){
        $selectedWorkspaceId = Workspace::find($id);

        $request->validate([
            'email' => "required|email|exists:users",
            
        ]);
    
        // Store email in session
        Session::put('reset_email_invitaion', $request->email);
    
        // Pass data as an array to the email view
        $data = ['email' => $request->email];
    
        Mail::send("emails.invitation-sending", $data, function($message) use ($request) {
            $message->to($request->email);
            $message->subject("Team Invitation");
        });
    
        return redirect()->back()->with('success', 'Your invitation has been sent.');
    }
    
}
