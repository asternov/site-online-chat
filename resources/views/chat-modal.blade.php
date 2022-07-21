@extends('layouts.modal')


@section('content')


    <button style="left: 0" class="btn btn-success btn-sm  w-100 h-100 top-0 " id="open" @click="open" v-if="hidden">
        Chat
    </button>
    <div class="container p-0 h-100 " style="max-width: 100vw; max-height: 100vh;  height: 100%" v-else>
        <div class="card" style="border-width: 0px">
            <div class="card-header  bg-dark">
                <div class="d-flex justify-content-center text-white mx-auto" style="margin-bottom: -1.5em">Все трейдеры здесь</div><br>
                <div class="d-flex justify-content-end" style="margin-top: -2em">
                <button class="btn btn-dark btn-sm" id="hideChat" @click="hideChat">
                    _
                </button>
                <button class="btn btn-dark btn-sm" id="expand" @click="expand">
                    <i class="fa fa-square-o" aria-hidden="true" v-if="!this.wide"></i>
                    <i class="fa fa-compress" aria-hidden="true" v-else></i>
                </button>
                <button class="btn btn-dark btn-sm" id="close" @click="close">
                    X
                </button>
                </div>
            </div>
            <div class="card-header  bg-dark">
                <div class="text-white mx-auto" style="margin-bottom: -1.5em; vertical-align: middle;" v-html="this.name">
                </div>
                <div class=" text-white bg-warning rounded-3 float-end px-2" @click="restart" >Сменить имя</div>
            </div>

            <div class="card-body bg-dark py-1">
                <chat-messages  v-on:messagedelete="deleteMessage" :wide="wide" :messages="messages" :admin="{{ Auth::check() ? 1 : 0 }}"></chat-messages>
            </div>
            <div class="card-footer bg-dark">
                <chat-form v-on:messagesent="addMessage"  ref="form"></chat-form>
            </div>
        </div>
    </div>
@endsection
