<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">
                        {{ __('Sign up') }}
                    </a>
                @endauth
            </div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <x-application-logo class="h-16 w-auto text-gray-700 sm:h-20" />
                    <h1 class="ml-2 mt-4 sm:mt-6 text-3xl sm:text-4xl font-semibold text-gray-900 leading-tight dark:text-white">
                        {{ config('app.name') }}
                    </h1>
                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <x-icons.home class="w-8 h-8 text-gray-500" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <p class="text-gray-900 dark:text-white">Collect Properties Details</p>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Copy the property's listing original URL from your favourite website,
                                    submit it to {{ config('app.name') }}, and you are ready to go.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <x-icons.group class="w-8 h-8 text-gray-500" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <p class="text-gray-900 dark:text-white">Add Your Peers</a>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Add your peers, mates, or partners to your own private group,
                                    and the details of your favourite properties, and all the discussion,
                                    will be shared amongst all of you.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <x-icons.comment class="w-8 h-8 text-gray-500" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <p class="text-gray-900 dark:text-white">Discuss</p>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Submit your preference whether your like the property or not,
                                    leave a comment, and start the discussion around your next new home.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                            <div class="flex items-center">
                                <x-icons.mail class="w-8 h-8 text-gray-500" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <p class="text-gray-900 dark:text-white">Get Notified Of Updates</p>
                                </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Whenever someone in your group adds a new property to {{ config('app.name') }},
                                    or leaves a comment, you can opt-in to be notified via email about the new content.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center pt-8 sm:hidden">
                    @auth
                        <x-buttons.primary-button-link href="{{ route('dashboard') }}">
                            Dashboard
                        </x-buttons.primary-button-link>
                    @else
                        <x-buttons.primary-button-link href="{{ route('register') }}">
                            {{ __('Sign up') }}
                        </x-buttons.primary-button-link>
                        <x-buttons.secondary-button-link href="{{ route('login') }}" class="ml-2">
                            {{ __('Login') }}
                        </x-buttons.secondary-button-link>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
