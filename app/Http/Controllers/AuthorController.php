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
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{

    public function check(Request $request)
    {
        $status = true;
        $q = Author::query()->where('name', $request->name);
        $author = $q->first();

            if ($author) {
                if (empty($author->hash) or
                    $author->hash !== $request->hash) {
                    $status = false;
                }
            }



            return ['status' => $status, 'name' => $request->name];
    }

    public function delete(Request $request)
    {
        $status = false;
        $q = Author::query()->where('name', $request->name);
        /** @var Author $author */
            $author = $q->first();

            if ($author && $author->hash === $request->hash) {
                    $status = $author->delete();
            }

            return ['status' => $status, 'data' => $request->name];
    }
}
