@extends('users.dashboard.layouts.sidebar')
@section('content')
    <div class="p-4 sm:ml-64 dark:bg-gray-900 h-screen ">
        <h1
            class="mb-4 text-4xl text-center text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400 mt-6 font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">
            Hello - {{ Auth::user()->name }}
        </h1>
        <p
            class="text-center font-extrabold leading-none tracking-tight text-gray-900 dark:text-white">
            Banao - PHP Laravel Project
        </p>
    @endsection
