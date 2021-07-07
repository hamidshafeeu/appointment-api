<x-app>
    @if( $booking->approved() )
        <div class="lg:grid lg:grid-cols-12">
            <div class="relative z-10 lg:col-start-1 lg:row-start-1 lg:col-span-4 lg:py-16 lg:bg-transparent pt-6">
                <div class="max-w-md mx-auto px-4 sm:max-w-3xl sm:px-6 lg:max-w-none lg:p-0">
                    <div class="aspect-w-10 aspect-h-6 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1">
                        <div class="bg-white flex justify-center p-6 py-10 rounded-3xl shadow-2xl">
                            {!! QrCode::size(300)->generate($booking->hash) !!}
                        </div>
                        {{-- <img class="object-cover object-center rounded-3xl shadow-2xl" src="https://images.unsplash.com/photo-1507207611509-ec012433ff52?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=934&q=80" alt=""> --}}
                    </div>
                </div>
            </div>

            <div class="relative lg:col-start-3 lg:row-start-1 lg:col-span-10 lg:rounded-3xl lg:grid lg:grid-cols-10 lg:items-center">
                <div class="hidden absolute inset-0 overflow-hidden rounded-3xl lg:block" aria-hidden="true">
                    <svg class="absolute bottom-full left-full transform translate-y-1/3 -translate-x-2/3 xl:bottom-auto xl:top-0 xl:translate-y-0"
                        width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
                        <defs>
                            <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                    fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="404" height="384" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
                    </svg>
                    <svg class="absolute top-full transform -translate-y-1/3 -translate-x-1/3 xl:-translate-y-1/2"
                        width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
                        <defs>
                            <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                    fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="404" height="384" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
                    </svg>
                </div>
                <div
                    class="relative max-w-md py-12 px-4 space-y-6 sm:max-w-3xl sm:py-16 sm:px-6 lg:max-w-none lg:p-0 lg:col-start-4 lg:col-span-6">
                    <h2 class="text-3xl text-center md:text-left font-extrabold text-gray-600" id="join-heading">
                        Vaccine Appointment Confirmation</h2>
                        <div class="border-b border-gray-200 flex flex-wrap pb-6">
                            <div class="w-full md:w-1/2">
                                <div class="text-sm text-gray-400">Name</div>
                                <div class="text-lg text-gray-600">{{ $booking->name }}</div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="text-sm text-gray-400">ID</div>
                                <div class="text-lg text-gray-600">{{ $booking->identifier }}</div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="text-sm text-gray-400">Site</div>
                                <div class="text-lg text-gray-600">{{ $booking->slot->center->name }}</div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="text-sm text-gray-400">Date</div>
                                <div class="text-lg text-gray-600">{{ \Illuminate\Support\Carbon::parse($booking->slot->date)->format('l, d M Y') }} @ {{ $booking->slot->start }}-{{ $booking->slot->end }}</div>
                            </div>
                            {{-- <div class="text-lg text-gray-600">{{ $booking->slot->start }} TO {{ $booking->slot->end }}</div>
                            <div class="text-lg text-gray-600">{{ $booking->slot->start }} TO {{ $booking->slot->end }}</div>
                            <div class="text-lg text-gray-600">{{ $booking->slot->date }}</div> --}}
                        </div>
                        <div>
                            <p class="pb-2">You must be present at the vaccination center at least 15 minutes before your scheduled appointment time.</p>
                            <p class="pb-2"> If you miss your scheduled appointment time, your booking will be <b>CANCELLED</b>, and you will have to book a new appointment for a different date.</p>
                            <div>
                                <div class="pt-10 pb-2 text-lg">
                                    Vaccination checklist:
                                </div>


                                <div class="ml-4 text-gray-600 flex items-center pb-2"> 
                                    <span class="material-icons mr-2 text-green-500">check_circle_outline</span> 
                                    <div>QR code you get with your appointment confirmation SMS</div> 
                                </div>
                                <div class="ml-4 text-gray-600 flex items-center pb-2"> 
                                    <span class="material-icons mr-2 text-green-500">check_circle_outline</span> 
                                    <div>ID card, passport, or drivers license</div> 
                                </div>
                                <div class="ml-4 text-gray-600 flex items-center pb-2"> 
                                    <span class="material-icons mr-2 text-green-500">check_circle_outline</span> 
                                    <div>Vaccine card</div> 
                                </div>
                                <div class="ml-4 text-gray-600 flex items-center pb-2"> 
                                    <span class="material-icons mr-2 text-green-500">check_circle_outline</span> 
                                    <div>Prescriptions for any long term medications</div> 
                                </div>
                                <div class="ml-4 text-gray-600 flex items-center pb-2"> 
                                    <span class="material-icons mr-2 text-green-500">check_circle_outline</span> 
                                    <div>Wear a short sleeved shirt, or loose fitting clothes that allow easy access to your upper arm</div> 
                                </div>
                                <div class="ml-4 text-gray-600 flex items-center pb-2"> 
                                    <span class="material-icons mr-2 text-green-500">check_circle_outline</span> 
                                    <div>have a meal before you visit</div> 
                                </div>

                            </div>
                        </div>
                    <a class="bg-red-700 bg-white block border border-transparent font-medium hover:bg-red-500 px-5 py-3 rounded-md shadow-md sm:inline-block sm:w-auto text-base text-center text-red-50 w-full"
                        href="/">Cancel Appointment</a>
                </div>
            </div>
        </div>
        @else
        <div class="relative">
            <div class="z-10">
                <h2 class="text-3xl text-center md:text-left font-extrabold text-gray-600" id="join-heading">
                    Vaccine Appointment Cancelled/Rejected
                </h2>
            </div>

        </div>
    @endif
</x-app>