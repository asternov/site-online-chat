@extends('layouts.modal')


@section('content')


    <button style="left: 0" class="btn btn-success btn-sm  w-100 h-100 top-0 " id="open" @click="close" v-if="closed">
        Chat
    </button>
    <div class="container p-0 h-100" v-else>
        <button style="z-index: 999; top: 10px; right: 16px" class="btn btn-success btn-sm position-absolute" id="close" @click="close">
            >
        </button>
        <div class="card">
            <div class="card-header">
                <chat-form v-on:messagesent="addMessage" ></chat-form>
            </div>
            <div class="card-body">
                <chat-messages  v-on:messagedelete="deleteMessage" :messages="messages" :admin="{{ Auth::check() ? 1 : 0 }}"></chat-messages>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
@endsection
