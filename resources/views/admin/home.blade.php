<x-app>

    <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow">

        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between">
            <div class="text-lg leading-6 font-medium text-gray-900">
                Appointments {{ $bookings->total() }}
            </div>
            <form action="">
                <input type="text" placeholder="Search.." value="{{ request('q') }}" name="q" id="q" autocomplete="search" class="block border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 max-w-lg p-2 rounded-md shadow-sm sm:max-w-xs sm:text-sm w-full">
            </form>
        </div>

        <ul class="divide-y divide-gray-200" aria-disabled="true">
            @foreach ($bookings as $booking)
            <li>
                <a href="#" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6 flex justify-between">
                        <div class="flex flex-col ">
                            <div class="text-sm font-medium text-indigo-600 truncate">
                                {{ $booking->identifier }}
                            </div>
                            <div class="flex-shrink-0 flex flex-col">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $booking->status }}
                                </span>
                            </div>

                            <div class="flex text-sm">{{ $booking->slot->center->name }} </div>
                            <div class="flex text-sm">{{ $booking->slot->date }} </div>
                            <div class="bg-gray-400 flex px-2 rounded-lg text-sm text-white">{{ $booking->slot->start }}-{{ $booking->slot->end }}</div>
                        </div>
                        <div class="mt-2 flex flex-col">
                            <div class="sm:flex">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                        x-description="Heroicon name: solid/users" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                        </path>
                                    </svg>
                                    <div>{{ $booking->name }}</div>
                                </div>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                    x-description="Heroicon name: solid/location-marker"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $booking->phone }}
                            </div>

                        </div>

                        <div class="flex flex-col items-end justify-around mt-2">
                            @if( $booking->approved() )
                            <form action="{{ route('resend') }}" method="POST">
                                @csrf
                                <input type="hidden" name="hash" value="{{ $booking->hash }}">
                                <button type="submit" class="bg-green-700 px-4 py-1 rounded-lg text-white hover:bg-green-500">Resend</button>
                            </form>
                            @endif

                            {{-- @if( $booking->pending() ) --}}
                            <form onsubmit="ask(event, 'Are you sure you want to reject {{$booking->name}}?')" action="{{ route('cancel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="hash" value="{{ $booking->hash }}">
                                <button type="submit" class="bg-red-700 px-4 py-1 rounded-lg text-white hover:bg-red-500">Reject</button>
                            </form>
                            {{-- @endif --}}
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        <div class="p-4 border-t">
            {{ $bookings->links() }}
        </div>
    </div>


    <script>

        function ask(evt, message) {
            if(!confirm(message)) {
                evt.preventDefault();
            }
            return false;
        }

    </script>
</x-app>
