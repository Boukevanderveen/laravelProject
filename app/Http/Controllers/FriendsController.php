<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Carbon\Carbon;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friend;
use Illuminate\Support\Facades\Validator;
use Auth;

class FriendsController extends Controller
{

    function navigateToDashboard()
    {
        if (!Auth::check()) 
        {
            return view("auth.login");
        }
        $currentuser = Auth::user()->name;
        $records = DB::table("friends")->where("friend1", "=", $currentuser)->orwhere("friend2", "=", $currentuser)->get();

        return view('dashboard', ['records' => $records, 'currentuser' => $currentuser]);
    }

    function acceptFriendRequest(Request $request)
    {    
        $query = DB::table('friends')->insert([ 
    
            'friend1'=>$request->input('sender'),
            'friend2'=>$request->input('receiver'),
            'created_at'=> Carbon::now()
        ]);

        if($query)
        { 
            $id = $request->input('friendrequestid');
            $query2 = DB::table('friendrequests')->where('id', $id)->delete();
            if($query2)
            { 
            }
            else
            {
                
            }
        } 
        else 
        { 
            
        }   
    }

    function declineFriendRequest(Request $request)
    {    
        $id = $request->input('friendrequestid');
        $query = DB::table('friendrequests')->where('id', $id)->delete();
        if($query)
        {
            return redirect('/friendrequests');
        }
        else
        {
            // ERROR BERICHT
        }  
    }

    function deleteFriendRequest(Request $request)
    {    
        $id = $request->input('friendrequestid');
        $query = DB::table('friendrequests')->where('id', $id)->delete();
        if($query)
        { 
            return redirect('/friendrequests');
        }
        else
        {
            // ERROR BERICHT
        }  
    }

    function navigatetoSendFriendRequest()
    {
        return view("sendfriendrequest");
    }

    function navigatetoFriendRequests()
    {
        $currentuser = Auth::user()->name;

        $incomingFriendRequests = DB::table("friendrequests")->where("receiver", "=", $currentuser)->get();
        $incomingFriendRequestsCount = DB::table("friendrequests")->where("receiver", "=", $currentuser)->count();

        $outgoingFriendRequests = DB::table("friendrequests")->where("sender", "=", $currentuser)->get();
        $outgoingFriendRequestsCount = DB::table("friendrequests")->where("sender", "=", $currentuser)->count();

        return view('friendrequests', 
        [
            'incomingFriendRequests' => $incomingFriendRequests, 
            'incomingFriendRequestsCount' => $incomingFriendRequestsCount, 
            'outgoingFriendRequests' => $outgoingFriendRequests, 
            'outgoingFriendRequestsCount' => $outgoingFriendRequestsCount
        ]);
    }

    function navigatetoFriendsList()
    {
        $currentuser = Auth::user()->name;

        $records = Friend::whereIn('friend1', [$currentuser])->orWhereIn('friend2', [$currentuser])->get();
        $friendscount = DB::table("friends")->where("friend1", "=", $currentuser)->orwhere("friend2", "=", $currentuser)->count();

        return view('friendslist', ['records' => $records, 'currentuser' => $currentuser, 'friendscount' => $friendscount]);

    }

    function SendFriendRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender' => 'required',
            'receiver' => 'required',
        ]);
        if ($validator->fails())
        {  

        } 
            
        $receiver = $request->input('receiver');
        $currentuser = Auth::user()->name;
        
        //Valideert of gebruiker al bevriend is door records te tellen

        $alreadyfriendscount1 = DB::table("friends")->where("friend1", "=", $currentuser)->where("friend2", "=", $receiver)->count();
        $alreadyfriendscount2 = DB::table("friends")->where("friend1", "=", $receiver)->where("friend2", "=", $currentuser)->count();
        // 0 is false, 1 is true.
        $isalreadyfriend = $alreadyfriendscount1 + $alreadyfriendscount2;

        //Valideert of gebruiker al invited is door records te tellen

        $alreadyinvitedcount1 = DB::table("friendrequests")->where("sender", "=", $currentuser)->where("receiver", "=", $receiver)->count();
        $alreadyinvitedcount2 = DB::table("friendrequests")->where("sender", "=", $receiver)->where("receiver", "=", $currentuser)->count();
        // 0 is false, 1 is true.
        $isalreadyinvited = $alreadyinvitedcount1 + $alreadyinvitedcount2;
        
        //Controleerd of je naar jezelf een invite stuurd
        if($currentuser == $request->input('receiver'))
        {
            // Error: Je kunt geen invite naar jezelf sturen!
            return Redirect::back()->withErrors(['msg' => 'Je kunt geen invite naar jezelf sturen!']);
        }
        else
        {
        //Controleerd of de gebruiker bestaat
        if (!User::where('name', $receiver)->exists())
        {
            // Error: Gebruiker bestaat niet!
        }
        else
        {
        //Controleerd of je al bevriend bent met die gebruiker
        if ($isalreadyfriend == 1 || $isalreadyfriend > 1)
        {
            // Error: Je bent al bevriend met deze gebruiker!
        }
        else
        {
        //Controleerd of je al een invite hebt met die gebruiker
        if ($isalreadyinvited == 1 || $isalreadyinvited > 1)
        {
            // Error: Er is al in invite tussen jou en dat persoon!
        }
        else
        {

            $time = Carbon::now();
            $query = DB::table('friendrequests')->insert([ 
    
                'sender'=>$request->input('sender'),
                'receiver'=>$request->input('receiver'),
                'created_at'=> $time
            ]);
    
            if($query)
            { 
                return redirect('/friendrequests');

            } 
            else 
            { 
               // ERROR BERICHT 
            } 
        }
        }
        }
        }  
    }
}