<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.users.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('users.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.users.inputs.name')</x-shows.dt>
                        <x-shows.dd>{{ $user->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.users.inputs.email')</x-shows.dt
                        >
                        <x-shows.dd>{{ $user->email ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $user->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $user->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.roles.name')
                        </h5>
                        <div>
                            @forelse ($user->roles as $role)
                            <div
                                class="
                                    inline-block
                                    p-1
                                    text-center text-sm
                                    rounded
                                    bg-blue-400
                                    text-white
                                "
                            >
                                {{ $role->name }}
                            </div>
                            <br />
                            @empty - @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('users.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
