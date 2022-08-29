{{-- <div class="overflow-hidden mt-5 -mx-4 ring-1 ring-gray-300 sm:-mx-6 md:mx-0 md:rounded-lg">{{ $slot }}</div> --}}

<div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle">
            <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
