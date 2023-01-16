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
        return view('chat-widget');
    }

    public function fetchMessages()
    {
        return Message::query()->with('author')->get();
    }

    public function sendMessage(messageRequest $request)
    {
        $user = Author::where('name', $request->sender)->first();

        if (empty($user)) {
            $user = Author::query()->create([
                'name' => $request->sender,
                'color' => Author::getRandomColor(),
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
