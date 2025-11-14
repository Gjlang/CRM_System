<nav x-data="{ open: false, contact_open: false, forecast_open: false, bbtb_open: false, tracking_open: false, tutorial_open: false, admin_open: false, }" class="bg-slate-500 border-b border-slate-500">
    <!-- Primary Navigation Menu -->
    {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> --}}
    <div class="w-full">
        <div class="flex lg:flex justify-between h-16 bg-slate-500 px-2 md:my-auto">
            {{-- <div class="xl:flex md:flex md:my-auto"> --}}
            <div class="flex md:flex md:my-auto">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('announcement-index') }}">
                        <img src="/storage/images/bluedale_logo.jpg"
                            class="h-11 w-24 sm:h-5 sm:w-10 lg:h-11 lg:w-24 px-1 py-1 hover:h-12 bg-white rounded-md">
                    </a>
                </div>

                <!-- Navigation Links -->
                @can('view contact')
                    <div class="xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center md:text-xs font-bold text-slate-100  hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('Contact') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content" class="w-full">
                                    <x-nav-link
                                        class="w-20 md:text-xs text-center font-bold hover:bg-blue-300 hover:font-bold"
                                        :href="route('contact')" :active="request()->routeIs('contact')">
                                        {{ __('List') }}
                                    </x-nav-link>
                                    <br>
                                    @can('view contact summary')
                                        <x-nav-link class="w-20 md:text-xs font-bold hover:bg-blue-300 hover:font-bold"
                                            :href="route('contact-summary')" :active="request()->routeIs('contact-summary')">
                                            {{ __('Summary') }}
                                        </x-nav-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan

                @can('view todo')
                    <div
                        class="hidden sm:flex sm:items-center sm:ml-0 xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <x-nav-link class="w-full md:text-xs font-bold text-slate-100 hover:text-amber-400"
                            :href="route('todo')" :active="request()->routeIs('todo')">
                            <div class="text-slate-100 hover:text-amber-400">{{ __('To Do') }}</div>
                        </x-nav-link>
                    </div>
                @endcan

                @can('view followup')
                    <div
                        class="hidden sm:flex sm:items-center sm:ml-0 xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <x-nav-link class="w-full md:text-xs font-bold  " :href="route('followup')" :active="request()->routeIs('followup')">
                            <div class="text-slate-100 hover:text-amber-400">{{ __('Follow Up') }}</div>
                        </x-nav-link>
                    </div>
                @endcan

                @can('view forecast')
                    <div class="xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center md:text-xs font-bold text-slate-100 hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('Forecast') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content" class="">
                                    <x-nav-link class="w-20 md:text-xs hover:bg-blue-300 hover:font-bold" :href="route('forecast')"
                                        :active="request()->routeIs('forecast')">
                                        {{ __('List') }}
                                    </x-nav-link>
                                    <br>
                                    @can('view forecast summary')
                                        <x-nav-link class="w-20 md:text-xs hover:bg-blue-300 hover:font-bold" :href="route('forecast-summary')"
                                            :active="request()->routeIs('forecast-summary')">
                                            {{ __('Summary') }}
                                        </x-nav-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan

                @can('view project')
                    <div
                        class="hidden sm:flex sm:items-center sm:ml-0 xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <x-nav-link class="w-full md:text-xs text-slate-100 font-bold hover:text-amber-400"
                            :href="route('project')" :active="request()->routeIs('project')">
                            <div class="text-slate-100 hover:text-amber-400">{{ __('Project') }}</div>
                        </x-nav-link>
                    </div>
                @endcan

                @can('view performance')
                    <div
                        class="hidden sm:flex sm:items-center sm:ml-0 xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <x-nav-link class="w-full md:text-xs text-slate-100 hover:text-amber-400 font-bold"
                            :href="route('performance')" :active="request()->routeIs('performance')">
                            <div class="text-slate-100 hover:text-amber-400">{{ __('Performance') }}</div>
                        </x-nav-link>
                    </div>
                @endcan

                @can('view billboard/tempboard')
                    <div class="xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center md:text-xs font-bold text-slate-100 hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('BB / TP') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content" class="">
                                    <x-nav-link class="w-20 md:text-xs hover:bg-blue-300 hover:font-bold" :href="route('billboard')"
                                        :active="request()->routeIs('billboard')">
                                        {{ __('Billboard') }}
                                    </x-nav-link>
                                    <br>
                                    <x-nav-link class="w-20 md:text-xs hover:bg-blue-300 hover:font-bold" :href="route('tempboard')"
                                        :active="request()->routeIs('tempboard')">
                                        {{ __('Tempboard') }}
                                    </x-nav-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan

                @can('view tracking')
                    <div class="xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center md:text-xs font-bold text-slate-100 hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('Tracking') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content" class="w-full md:text-xs">
                                    @can('view tracking general')
                                        <x-nav-link class="w-20 md:text-xs hover:bg-blue-300 hover:font-bold" :href="route('tracking-general')"
                                            :active="request()->routeIs('tracking-general')">
                                            {{ __('General') }}
                                        </x-nav-link>
                                    @endcan
                                    <br>
                                    @can('view tracking tguide')
                                        <x-nav-link class="w-20 md:text-xs hover:bg-blue-300 hover:font-bold" :href="route('tracking-travel_guide')"
                                            :active="request()->routeIs('tracking-travel_guide')">
                                            {{ __('Travel Guide') }}
                                        </x-nav-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan


                <div class="xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                    <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                        <x-dropdown align="right" width="w-max">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center md:text-xs font-bold text-slate-100 hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Tutorials') }} </div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content" class="w-full">
                                <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                    :href="route('tutorial-contact')" :active="request()->routeIs('tutorial-contact')">
                                    {{ __('Contact') }}
                                </x-nav-link>

                                <br>
                                <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                    :href="route('tutorial-todo_followup')" :active="request()->routeIs('tutorial-todo_followup')">
                                    {{ __('To Do & Follow Up') }}
                                </x-nav-link>

                                <br>
                                <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                    :href="route('tutorial-forecast')" :active="request()->routeIs('tutorial-forecast')">
                                    {{ __('Forecast') }}
                                </x-nav-link>

                                <br>
                                <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                    :href="route('tutorial-project')" :active="request()->routeIs('tutorial-project')">
                                    {{ __('Project') }}
                                </x-nav-link>

                                <br>
                                <x-nav-link class="w-32 text-xs hover:bg-blue-300 hover:font-bold" :href="route('tutorial-performance')"
                                    :active="request()->routeIs('tutorial-performance')">
                                    {{ __('Performance') }}
                                </x-nav-link>

                                <br>
                                <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                    :href="route('tutorial-billboard_tempboard')" :active="request()->routeIs('tutorial-billboard_tempboard')">
                                    {{ __('BB / TP') }}
                                </x-nav-link>

                                <br>
                                <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                    :href="route('tutorial-tracking')" :active="request()->routeIs('tutorial-tracking')">
                                    {{ __('Tracking') }}
                                </x-nav-link>
                                @can('view tutorial admin')
                                    <br>

                                    <x-nav-link class="w-32 md:text-xs hover:bg-blue-300 hover:font-bold"
                                        :href="route('tutorial-admin')" :active="request()->routeIs('tutorial-admin')">
                                        {{ __('Admin') }}
                                    </x-nav-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>


                @can('view admin')
                    <div class="xl:-my-px xl:ml-10 lg:ml-5 xl:flex md:my-auto md:mx-auto">
                        <div class="hidden sm:flex sm:items-center sm:ml-0 px-1">
                            <x-dropdown align="right" width="w-max">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center md:text-xs font-bold text-slate-100 hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ __('Admin') }} </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content" class="w-32">
                                    @can('view admin announcement')
                                        <x-nav-link class="w-32 md:text-xs  hover:bg-blue-300 hover:font-bold"
                                            :href="route('announcement-edit')" :active="request()->routeIs('announcement-edit')">
                                            {{ __('Announcement') }}
                                        </x-nav-link>
                                    @endcan
                                    <br>
                                    @can('view admin data')
                                        <x-nav-link class="w-32 md:text-xs  hover:bg-blue-300 hover:font-bold"
                                            :href="route('admin-data')" :active="request()->routeIs('admin-data')">
                                            {{ __('Data') }}
                                        </x-nav-link>
                                    @endcan
                                    <br>
                                    @can('view admin user manage')
                                        <x-nav-link class="w-32 md:text-xs  hover:bg-blue-300 hover:font-bold"
                                            :href="route('admin-management')" :active="request()->routeIs('admin-management')">
                                            {{ __('User Management') }}
                                        </x-nav-link>
                                    @endcan
                                    <br>
                                    @can('view admin user access')
                                        <x-nav-link class="w-32 text-xs  hover:bg-blue-300 hover:font-bold" :href="route('admin-access')"
                                            :active="request()->routeIs('admin-access')">
                                            {{ __('User Access') }}
                                        </x-nav-link>
                                    @endcan
                                    <br>
                                    @can('view admin export import')
                                        <x-nav-link class="w-32 md:text-xs  hover:bg-blue-300 hover:font-bold"
                                            :href="route('admin-export')" :active="request()->routeIs('admin-export')">
                                            {{ __('Export/Import') }}
                                        </x-nav-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @endcan

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-2 bg-slate-500 px-1">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-extrabold text-amber-400 hover:text-amber-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="ml-1 mr-2 flex items-center sm:hidden">
                    <button x-on:click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 border-2 border-slate-700 hover:text-slate-100 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 focus:text-slate-100 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path x-bind:class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path x-bind:class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu (MOBILE <768px W)-->
        <div x-bind:class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden ml-16">
            <div class="pl-10 mt-2">
                @can('view contact')
                    <div class="pl-3 py-1 border-t rounded-md">
                        <label x-on:click="contact_open = !contact_open"
                            class="ml-1 font-extrabold text-white text-sm">Contact</label>
                        <div x-bind:class="{ 'block': contact_open, 'hidden': !contact_open }" class="hidden">
                            @can('view contact')
                                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('List') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view contact summary')
                                <x-responsive-nav-link :href="route('contact-summary')" :active="request()->routeIs('contact-summary')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('Summary') }}
                                </x-responsive-nav-link>
                            @endcan
                        </div>
                    </div>
                @endcan

                @can('view todo')
                    <div class=" border-t rounded-md">
                        <x-responsive-nav-link :href="route('todo')" :active="request()->routeIs('todo')"
                            class="font-extrabold text-white text-sm">
                            {{ __('To Do') }}
                        </x-responsive-nav-link>
                    </div>
                @endcan
                @can('view followup')
                    <div class=" border-t rounded-md">
                        <x-responsive-nav-link :href="route('followup')" :active="request()->routeIs('followup')"
                            class="font-extrabold text-white text-sm">
                            {{ __('Follow Up') }}
                        </x-responsive-nav-link>
                    </div>
                @endcan
                @can('view forecast')
                    <div class="pl-3 py-1 border-t rounded-md text-sm">
                        <label x-on:click="forecast_open = !forecast_open"
                            class="ml-1 font-extrabold text-white">Forecast</label>
                        <div x-bind:class="{ 'block': forecast_open, 'hidden': !forecast_open }" class="hidden">
                            @can('view forecast')
                                <x-responsive-nav-link :href="route('forecast')" :active="request()->routeIs('forecast')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('List') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view forecast summary')
                                <x-responsive-nav-link :href="route('forecast-summary')" :active="request()->routeIs('forecast-summary')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('Summary') }}
                                </x-responsive-nav-link>
                            @endcan
                        </div>
                    </div>
                @endcan
                @can('view project')
                    <div class=" border-t rounded-md">
                        <x-responsive-nav-link :href="route('project')" :active="request()->routeIs('project')"
                            class="font-extrabold text-white text-sm">
                            {{ __('Project') }}
                        </x-responsive-nav-link>
                    </div>
                @endcan
                @can('view performance')
                    <div class=" border-t rounded-md">
                        <x-responsive-nav-link :href="route('performance')" :active="request()->routeIs('performance')"
                            class="font-extrabold text-white text-sm">
                            {{ __('Performance') }}
                        </x-responsive-nav-link>
                    </div>
                @endcan
                @can('view billboard/tempboard')
                    <div class="pl-3 py-1  border-t rounded-md">
                        <label x-on:click="bbtb_open = !bbtb_open"
                            class="ml-1 font-extrabold text-white text-sm">BB/TP</label>
                        <div x-bind:class="{ 'block': bbtb_open, 'hidden': !bbtb_open }" class="hidden">
                            <x-responsive-nav-link :href="route('billboard')" :active="request()->routeIs('billboard')"
                                class="text-amber-400 text-xs font-bold">
                                {{ __('Billboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('tempboard')" :active="request()->routeIs('tempboard')"
                                class="text-amber-400 text-xs font-bold">
                                {{ __('Tempboard') }}
                            </x-responsive-nav-link>
                        </div>
                    </div>
                @endcan
                @can('view tracking')
                    <div class="pl-3 py-1 border-t rounded-md">
                        <label x-on:click="tracking_open = !tracking_open"
                            class="ml-1 font-extrabold text-white text-sm">Tracking</label>
                        <div x-bind:class="{ 'block': tracking_open, 'hidden': !tracking_open }" class="hidden">
                            @can('view tracking general')
                                <x-responsive-nav-link :href="route('tracking-general')" :active="request()->routeIs('tracking-general')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('General') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view tracking tguide')
                                <x-responsive-nav-link :href="route('tracking-travel_guide')" :active="request()->routeIs('tracking-travel_guide')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('Travel Guide') }}
                                </x-responsive-nav-link>
                            @endcan
                        </div>
                    </div>
                @endcan
                <div class="pl-3 py-1 border-t rounded-md">
                    <label x-on:click="tutorial_open = !tutorial_open"
                        class="ml-1 font-extrabold text-white text-sm">Tutorial</label>
                    <div x-bind:class="{ 'block': tutorial_open, 'hidden': !tutorial_open }" class="hidden">
                        <x-responsive-nav-link :href="route('tutorial-contact')" :active="request()->routeIs('tutorial-contact')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('Contact') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-todo_followup')" :active="request()->routeIs('tutorial-todo_followup')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('ToDo & FollowUp ') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-forecast')" :active="request()->routeIs('tutorial-forecast')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('Forecast') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-project')" :active="request()->routeIs('tutorial-project')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('Project') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-performance')" :active="request()->routeIs('tutorial-performance')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('Performance') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-billboard_tempboard')" :active="request()->routeIs('tutorial-billboard_tempboard')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('BB/TP') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-tracking')" :active="request()->routeIs('tutorial-tracking')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('Tracking') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tutorial-admin')" :active="request()->routeIs('tutorial-admin')"
                            class="text-amber-400 text-xs font-bold">
                            {{ __('Admin') }}
                        </x-responsive-nav-link>
                    </div>
                </div>
                @can('view admin')
                    <div class="pl-3 py-1 border-t rounded-md">
                        <label x-on:click="admin_open = !admin_open"
                            class="ml-1 font-extrabold text-white text-sm">Admin</label>
                        <div x-bind:class="{ 'block': admin_open, 'hidden': !admin_open }" class="hidden">
                            @can('view admin announcement')
                                <x-responsive-nav-link :href="route('announcement-edit')" :active="request()->routeIs('announcement-edit')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('Announcement') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view admin data')
                                <x-responsive-nav-link :href="route('admin-data')" :active="request()->routeIs('admin-data')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('Data') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view admin user manage')
                                <x-responsive-nav-link :href="route('admin-management')" :active="request()->routeIs('admin-management')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('User Manage') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view admin user access')
                                <x-responsive-nav-link :href="route('admin-access')" :active="request()->routeIs('admin-access')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('User Access') }}
                                </x-responsive-nav-link>
                            @endcan
                            @can('view admin export import')
                                <x-responsive-nav-link :href="route('admin-export')" :active="request()->routeIs('admin-export')"
                                    class="text-amber-400 text-xs font-bold">
                                    {{ __('Export/Import') }}
                                </x-responsive-nav-link>
                            @endcan
                        </div>
                    </div>
                @endcan
            </div>



            <!-- Responsive Settings Options -->
            <div class="pt-2 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-bold text-base text-amber-400">{{ Auth::user()->name }}</div>
                    <div class="font-bold text-xs text-green-300">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}"
                        class="border-gray-200 bg-slate-600 border rounded-md w-max">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            class=" text-red-400 uppercase text-xs font-semibold font-mono"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
</nav>
