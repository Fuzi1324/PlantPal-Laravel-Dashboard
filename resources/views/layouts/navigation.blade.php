<nav class="navbar">
    <div class="flex items-center">
        <a href="{{ route('installations.index') }}" class="back-button">
            &lt;
        </a>
        <span class="logo">PLANTPAL</span>
    </div>
    <div class="flex items-center">
        @auth
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="dropdown-trigger-button">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="dropdown-content">
                        <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                          this.closest('form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>
        @else
            <a href="{{ route('login') }}" class="text-white hover:text-gray-200 text-sm">
                Login
            </a>
        @endauth
    </div>
</nav>
