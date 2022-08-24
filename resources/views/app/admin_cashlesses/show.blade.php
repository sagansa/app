<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.admin_cashlesses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('admin-cashlesses.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.admin_cashlesses.inputs.cashless_provider_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($adminCashless->cashlessProvider)->name
                            ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.admin_cashlesses.inputs.username')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $adminCashless->username ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.admin_cashlesses.inputs.email')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $adminCashless->email ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.admin_cashlesses.inputs.no_telp')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $adminCashless->no_telp ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.admin_cashlesses.inputs.password')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $adminCashless->password ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $adminCashless->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $adminCashless->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('admin-cashlesses.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\account_cashless_admin_cashless::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Account Cashlesses </x-slot>

                <livewire:admin-cashless-account-cashlesses-detail
                    :adminCashless="$adminCashless"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
