@extends('layouts.modal')


@section('content')


    <button style="left: 0" class="btn btn-success btn-sm  w-100 h-100 top-0 " id="open" @click="open" v-if="hidden">
        Chat
    </button>
    <div class="container p-0 h-100" v-else>
        <div class="card">
            <div class="card-header float-end justify-content-end text-right bg-dark">
                <button class="btn btn-dark btn-sm mx-auto" id="hideChat" @click="hideChat">
                    _
                </button>
                <button class="btn btn-dark btn-sm" id="expand" @click="expand">
                    <i class="fa fa-square-o" aria-hidden="true"></i>
                </button>
                <button class="btn btn-dark btn-sm" id="close" @click="close">
                    X
                </button>
            </div>

            <div class="card-body bg-dark py-1">
                <chat-messages  v-on:messagedelete="deleteMessage" :messages="messages" :admin="{{ Auth::check() ? 1 : 0 }}"></chat-messages>
            </div>
            <div class="card-footer bg-dark">
                <chat-form v-on:messagesent="addMessage" ></chat-form>
            </div>
        </div>
    </div>
@endsection
