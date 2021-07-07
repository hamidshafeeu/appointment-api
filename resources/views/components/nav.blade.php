<nav class="bg-white shadow sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="-ml-2 mr-2 flex items-center md:hidden"><button type="button"
                        aria-controls="mobile-menu" aria-expanded="false"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500"><span
                            class="sr-only">Open main menu</span><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="block h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true" class="hidden h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg></button></div>
                <div class="flex-shrink-0 flex items-center"><img
                        src="https://my.health.mv/img/dhifaau-logo-primary.7ec8b664.png" alt=""
                        class="block h-8 w-auto"></div>
                <div class="hidden md:ml-6 md:flex md:space-x-8"><a href="#"
                        class="px-6 border-gray-200 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Appointment </a>
                        <a href="https://my.health.mv"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        my<b>Health</b></a></div>
            </div>

            @auth
            <form class="md:ml-6 flex md:space-x-8" action="{{ route('admin.logout') }}" method="post">
                @csrf
                <button type="submit"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Logout</button>
            </form>
            @endauth
        </div>
    </div>
</nav>