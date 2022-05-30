<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    //Add the below functions
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function fetchMessages()
    {
        return Message::query()->whereHas('user')->with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $username = $request->input('message');
        $q = User::query()->where('name', $username);

        if ($q->count()) {
            $user = $q->first();
        } else {
            $user = User::create([
                'name' => $username
            ]);
        }

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
