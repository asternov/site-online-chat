<?php

namespace App\Http\Controllers;

use App\Events\MessageDelete;
use App\Events\MessageSent;
use App\Http\Requests\messageRequest;
use App\Models\Author;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function widget()
    {
        return view('chat-modal');
    }

    public function fetchMessages()
    {
        return Message::query()->with('author')->get();
    }

    public function sendMessage(messageRequest $request)
    {
        function random_color_part() {
            return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        }

        function random_color() {
            return random_color_part() . random_color_part() . random_color_part();
        }

        $q = Author::query()->where('name', $request->sender);

        if ($q->count()) {
            $user = $q->first();
        } else {
            $user = Author::query()->create([
                'name' => $request->sender,
                'color' => random_color(),
            ]);
        }

        /** @var Author $user */
        $message = $user->messages()->create([
            'message' => $request->message
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!', 'color' => $user->color];
    }

    public function destroy(Request $request, Message $message)
    {
        $id = $message->id;

        if ($message->delete()) {
            broadcast(new MessageDelete($id))->toOthers();

            return ['status' => 'Message Deleted!'];
        }

        return ['status' => 'Error'];
    }
}
