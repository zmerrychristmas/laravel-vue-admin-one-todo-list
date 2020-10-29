@extends('layouts.app')

@section('content')
    @component('components.full-page-section')
        @component('components.card')
            @slot('title')
                <span class="icon"><i class="mdi mdi-laravel"></i></span>
                <span>Home Test</span>
            @endslot

            <div class="content">
                <p>
                    Hi, My name is Huy Binh. This is Laravel Demo of Home Test
                    Please, <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>&hellip;
                </p>
                <p>
                    &mdash; <b>Login:</b> user@example.com<br>
                    &mdash; <b>Password:</b> secret
                </p>
                <hr />
                <p>
                    &mdash; <b>Login(admin):</b> admin@example.com<br>
                    &mdash; <b>Password:</b> admin
                </p>
            </div>
            <hr>
            <div class="buttons">
                <a href="{{ route('login') }}" class="button is-black">Login</a>
                <a href="{{ route('register') }}" class="button is-black is-outlined">Register</a>
            </div>
        @endcomponent
    @endcomponent
@endsection