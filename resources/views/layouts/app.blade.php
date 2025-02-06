<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}@yield('pageTitle')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <script src="{{asset('js/app.js')}}"></script>
    @yield('meta')
    @vite('resources/css/app.css')
    {{-- @vite('resources/js/app.js') --}}
    <!-- Scripts -->
    {{-- @viteReactRefresh
    @vite('resources/react/app.tsx') --}}
    <script>
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js')
          .then((registration) => {
            console.log('Service Worker registered with scope:', registration.scope);
          })
          .catch((error) => {
            console.log('Service Worker registration failed:', error);
          });
      }
    </script>
    
</head>
<body>
    <div id="app">

        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
              <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 right-0 flex items-center sm:hidden">
                  <!-- Mobile menu button-->
                  <button type="button" onclick="toggleHamburgerMenu()" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!--
                      Icon when menu is closed.
          
                      Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!--
                      Icon when menu is open.
          
                      Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-between">
                  <div class="flex flex-shrink-0 items-center">
                        <a class="text-white" href="{{route('home')}}">MyLogo</a>
                  </div>
                  <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{route('my-fellows')}}">Fellows</a>
                        <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{route('mine-clearence')}}">Mine Clearence</a>
                        <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300" href="#">Sandtopia</a>
                        @guest
                            @if (Route::has('login'))
                                    <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                
                            @endif
                            
                            @if (Route::has('register'))
                                    <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                
                            @endif
                        @else
                            
                                <div >
                                    <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            
                        @endguest
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" id="mobile-menu" style="display: none">
              <div class="space-y-1 px-2 pb-3 pt-2">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{route('my-fellows')}}">Fellows</a>
                <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{route('mine-clearence')}}">Mine Clearence</a>
                <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300" href="{{route('sandtopia')}}">Sandtopia</a>
                @guest
                    @if (Route::has('login'))
                            <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        
                    @endif
                    
                    @if (Route::has('register'))
                            <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                        
                    @endif
                @else
                    
                        <div >
                            <a class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    
                @endguest
              </div>
            </div>
          </nav>

        

        <main id="main-container" class="flex items-center justify-center">
            @yield('content')
        </main>
        
        <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden p-2">
          @yield('modals')
        </div>
        
        <script>
          function toggleModal() {
            document.getElementById('modal-overlay').classList.toggle('hidden');
          }
        </script>
    </div>
</body>
</html>
