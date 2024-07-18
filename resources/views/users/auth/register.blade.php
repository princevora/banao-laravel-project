@extends('users.layouts.main')
@section('title', "Register")
@section('content')
    <section class="bg-gray-50 h-screen dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-full lg:py-0">
            <h1 class="flex gap-2 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="mt-1 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                Banao - Laravel Project
            </h1>
            <div class="w-full max-w-md bg-white rounded-lg shadow-xl dark:border dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Register your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route("register.submit") }}" method="POST">
                        
                        <!-- Global errors may occur when the user register in mysql or queries -->
                        @error('other')
                            <small class="text-red-600 p-2">
                                {{ $message }}
                            </small>
                        @enderror

                        <!-- Csrf Token Field -->
                        @csrf
                        
                        <!-- Main Form -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                Name
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="John Doe"
                                required
                                value="{{ old('name') }}"
                            />
                        </div>
                        @error('name')
                            <small class="text-red-600 p-2">
                                {{ $message }}
                            </small>
                        @enderror
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" 
                                required
                                value="{{ old('email') }}"
                            />
                        </div>
                        @error('email')
                            <small class="text-red-600 p-2">
                                {{ $message }}
                            </small>
                        @enderror
                        <div>
                            <label 
                                for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Password
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required
                            >
                        </div>
                        @error('password')
                            <small class="text-red-600 p-2">
                                {{ $message }}
                            </small>
                        @enderror
                        <button type="submit"
                            class="w-full text-white bg-gray-900  focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Register
                        </button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Already have an account yet? 
                            <a href="{{ route('login') }}"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                                Sign In    
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
