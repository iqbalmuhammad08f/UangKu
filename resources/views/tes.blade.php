@extends('layouts.app')

@section('content.layout')
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                <span>Dropdown Menu</span>
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link href="#">
                Profile
            </x-dropdown-link>
            <x-dropdown-link href="#">
                Settings
            </x-dropdown-link>
            <div class="border-t border-gray-100"></div>
            <x-dropdown-link href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
@endsection
