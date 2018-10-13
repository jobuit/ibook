@extends('layouts.app')
@section('content')
<link href="{{ URL::asset('css/welcome.css') }}" rel="stylesheet">
<div class="flex-center position-ref full-height contenido">

            <div class="content">
                <div class="title m-b-md">
                    iBook
                </div>

                <div class="links">
                    @if (Route::has('login'))
                            @auth
                                <a class="btn btn-primary" href="{{ url('/home')}}">Inicio</a>
                            @else
                                <a class="btn btn-primary" href="{{ route('login') }}" >Iniciar sesion</a>
                                <a class="btn btn-danger" href="{{ route('register') }}">Registrarme</a>
                            @endauth
                    @endif
                </div>
            </div>
        </div>

