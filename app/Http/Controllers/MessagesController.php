<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Events\formSubmitted;
use Illuminate\Support\Facades\DB;
Use Carbon\Carbon;

class MessagesController extends Controller
{
    function navigateToDM(Request $request)
    {
    $currentuser = Auth::user()->name;
    $targetuser = $request->input('receiver');
    
    //Haalt de id op dat gemeenschappelijk is tussen jou en je vriend
    if (DB::table("friends")->where("friend1", "=", $currentuser)->where("friend2", "=", $targetuser)->exists())
    {
        $userRecord = DB::table("friends")->where("friend1", "=", $currentuser)->where("friend2", "=", $targetuser)->first();
    }
    else
    {
        $userRecord = DB::table("friends")->where("friend1", "=", $targetuser)->where("friend2", "=", $currentuser)->first();
    }

    $dmId = $userRecord->id;

    //Pakt alle records met dezelfde dm_id om alle berichten tussen jou en je vriend op te halen.
    $messages = DB::table("dmmessages")->where("dm_id", "=", $dmId)->get();

    return view('dm', ['currentuser' => $currentuser, 'targetuser' => $targetuser, 'dmId' => $dmId, 'messages' => $messages]);
    }

    function insertMessageInDB(Request $request)
    {    
        $query = DB::table('dmmessages')->insert([ 
            'message'=>$request->input('message'),
            'sender'=>$request->input('sender'),
            'receiver'=>$request->input('receiver'),
            'editedmessage'=>null,
            'created_at'=> Carbon::now(),
            'dm_id'=>$request->input('dmid'),
        ]);
        if($query)
        { 
            $message = request()->message;
            $receiver = request()->receiver;
            $sender = request()->sender;
            $dmid = request()->dmid;
        
            event(new FormSubmitted($message, $receiver, $sender, $dmid));

        }
        else
        {            
        }
    }

}
