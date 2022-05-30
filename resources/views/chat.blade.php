@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <chat-form v-on:messagesent="addMessage" ></chat-form>
            </div>
            <div class="card-body">
                <chat-messages :messages="messages"></chat-messages>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
@endsection
