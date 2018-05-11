@extends('layouts.app')

@section('content')
    <div class="content main-content with-sidebar">
        <section role="sidebar" id="main__sidebar">
            <div id="user__info">
                <figure class="image avatar">
                    <img src="{{auth()->user()->avatar}}" alt="User avatar">
                </figure>
            </div>
            <div id="waves">
                <div class="wave wave--1"></div>
                <div class="wave wave--2"></div>
                <div class="wave wave--3"></div>
            </div>
            <div id="sidebar__content" class=""></div>
        </section>
        <section role="chatbox" id="main__chatbox"></section>
    </div>

@endsection
