<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.parent_account_cashlesses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('parent-account-cashlesses.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.parent_account_cashlesses.inputs.cashless_provider_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($parentAccountCashless->cashlessProvider)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.parent_account_cashlesses.inputs.username')</x-shows.dt>
                        <x-shows.dd>{{ $parentAccountCashless->username ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.parent_account_cashlesses.inputs.email')</x-shows.dt>
                        <x-shows.dd>{{ $parentAccountCashless->email ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.parent_account_cashlesses.inputs.no_telp')</x-shows.dt>
                        <x-shows.dd>{{ $parentAccountCashless->no_telp ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('parent-account-cashlesses.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\StoreCashless::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Store Cashlesses </x-slot>

                    <livewire:parent-account-cashless-store-cashlesses :parentAccountCashless="$parentAccountCashless" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
