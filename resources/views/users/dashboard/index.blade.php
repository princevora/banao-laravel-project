@extends('users.dashboard.layouts.sidebar')
@section('content')
    <div class="p-4 sm:ml-64 dark:bg-gray-900 h-screen ">
        <h1
            class="mb-4 text-4xl text-center text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400 mt-6 font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl">
            Hello - {{ Auth::user()->name }}
        </h1>
        <p class="text-center font-extrabold leading-none tracking-tight text-gray-900 dark:text-white">
            Banao - PHP Laravel Project
        </p>

        
        <div class="flex justify-center">
            <div class="w-full max-w-[16rem] mt-10">
                <h1 class="mb-4 font-extrabold leading-none tracking-tight text-gray-900  dark:text-white">
                    Api Token 
                </h1>
                <div class="relative">
                    <label for="npm-install-copy-button" class="sr-only">Label</label>
                    <input id="npm-install-copy-button" type="text"
                        class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ Auth::user()->api_token }}" disabled readonly>
                    <button data-copy-to-clipboard-target="npm-install-copy-button"
                        data-tooltip-target="tooltip-copy-npm-install-copy-button"
                        class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-500 rounded-lg p-2 inline-flex items-center justify-center">
                        <span id="default-icon">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 20">
                                <path
                                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                            </svg>
                        </span>
                        <span id="success-icon" class="hidden items-center">
                            <svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                        </span>
                    </button>
                    <div id="tooltip-copy-npm-install-copy-button" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        <span id="default-tooltip-message">Copy to clipboard</span>
                        <span id="success-tooltip-message" class="hidden">Copied!</span>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
