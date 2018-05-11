@extends('layouts.app')

@section('content')
    <div class="content main-content with-sidebar">
        <section role="sidebar" id="main__sidebar">
            <div id="user__info">
                <figure class="image is-128x128">
                    <img src="{{auth()->user()->avatar}}" alt="User avatar">
                </figure>
            </div>
        </section>
        <section role="chatbox" id="main__chatbox"></section>
    </div>

@endsection
