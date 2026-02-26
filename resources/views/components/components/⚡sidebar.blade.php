<?php

use Livewire\Component;

new class extends Component
{
    public $title = 'Dashboard';
};
?>

<aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <h2 class="text-xl font-bold mb-6">{{$title}}</h2>
    <!-- Menu -->
    <nav>
        <ul>
            <li class="mb-2">
                <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Dashboard</a>
            </li>
            <!-- Dropdown -->
            <li class="mb-2">
                <button onclick="toggleDropdown()" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700 focus:outline-none">
                    <span>Projects</span>
                    <svg id="dropdownIcon" class="w-4 h-4 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="dropdownMenu" class="hidden pl-6 mt-2 space-y-2">
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Project A</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Project B</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Project C</a></li>
                </ul>
            </li>
            <li class="mb-2">
                <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Settings</a>
            </li>
        </ul>
    </nav>
</aside>