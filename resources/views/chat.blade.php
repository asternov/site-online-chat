@extends('layouts.app')


@section('content')
    <div class="container">
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
