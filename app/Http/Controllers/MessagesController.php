<?php

namespace App\Http\Controllers;

use App\Events\MessageDelete;
use App\Events\MessageSent;
use App\Http\Requests\messageRequest;
use App\Models\Author;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MessagesController extends Controller
{
    public function index()
    {
        setcookie("TestCookie", 'test', time()+3600);
        return view('chat');
    }

    public function widget()
    {
        return view('chat-modal');
    }

    public function fetchMessages()
    {
        return Message::query()->whereHas('author')->with('author')->get();
    }

    public function sendMessage(messageRequest $request)
    {
        function random_color_part() {
            return str_pad( dechex( mt_rand( 128, 255 ) ), 2, '0', STR_PAD_LEFT);
        }

        function random_color() {
            return random_color_part() . random_color_part() . random_color_part();
        }

        $q = Author::query()->where('name', $request->sender);

        if ($q->count()) {
            $user = $q->first();
            $hash = false;

            if (empty($user->hash) or
                $user->hash !== $request->hash) {
                abort(403);
            }
        } else {
            $color = random_color();
            $hash = Hash::make($request->sender . $color . random_int(PHP_INT_MIN, PHP_INT_MAX));

            $user = Author::query()->create([
                'name' => $request->sender,
                'color' => $color,
                'hash' => $hash,
            ]);
        }

        /** @var Author $user */
        /** @var Message $message */
        $message = $user->messages()->create([
            'message' => $request->message
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        $response = response()->json([
            'status' => 'Message Sent!',
            'color' => $user->color,
            'user' => $message->author->name,
            'text' => $message->message,
            'hash' => $hash,
        ]);

        return $response;
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
