<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.account_cashlesses.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Data seluruh account cashless</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">

        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-2/3">
                    <x-buttons.link wire:click.prevent="$toggle('showFilters')">
                        @if ($showFilters)
                            Hide
                        @endif Advanced Search...
                    </x-buttons.link>
                    @if ($showFilters)
                        <x-filters.group>
                            <x-filters.label>Store</x-filters.label>
                            <x-filters.select wire:model="filters.store_id">
                                @foreach ($stores as $label => $value)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-filters.select>
                        </x-filters.group>
                        <x-filters.group>
                            <x-filters.label>Store Cashless</x-filters.label>
                            <x-filters.select wire:model="filters.store_cashless_id">
                                @foreach ($storeCashlesses as $label => $value)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-filters.select>
                        </x-filters.group>
                        <x-filters.group>
                            <x-filters.label>Cashless Provider</x-filters.label>
                            <x-filters.select wire:model="filters.cashless_provider_id">
                                @foreach ($cashlessProviders as $label => $value)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-filters.select>
                        </x-filters.group>


                        <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                        </x-buttons.link>
                    @endif
                </div>
                <div class="mt-1 text-right md:w-1/3">
                    @can('create', App\Models\accountCashless::class)
                        <a href="{{ route('account-cashlesses.create') }}">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </x-jet-button>
                        </a>
                    @endcan
                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.cashless_provider_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.account_cashlesses.inputs.store_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.account_cashlesses.inputs.store_cashless_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.account_cashlesses.inputs.email')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.account_cashlesses.inputs.username')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.account_cashlesses.inputs.no_telp')</x-tables.th-left-hide>
                @role('super-admin|manager|supervisor')
                    <x-tables.th-left-hide>@lang('crud.account_cashlesses.inputs.password')</x-tables.th-left-hide>
                    {{-- <x-tables.th-left-hide>created at</x-tables.th-left-hide>
                    <x-tables.th-left-hide>updated at</x-tables.th-left-hide> --}}
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($accountCashlesses as $accountCashless)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($accountCashless->cashlessProvider)->name ?? '-' }}
                            </x-slot>
                            <x-slot name="sub">

                                <p>store: {{ optional($accountCashless->store)->nickname ?? '-' }}</p>
                                <p>store cashless: {{ optional($accountCashless->storeCashless)->name ?? '-' }}</p>
                                <p>email: {{ $accountCashless->email ?? '-' }}</p>
                                <p>accountname: {{ $accountCashless->username ?? '-' }}</p>
                                <p>no telp: {{ $accountCashless->no_telp ?? '-' }}</p>
                                @role('super-admin|manager|supervisor')
                                    <p>password: {{ $accountCashless->password ?? '-' }}</p>
                                @endrole
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ optional($accountCashless->store)->nickname ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($accountCashless->storeCashless)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->email ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->username ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-right-hide>{{ $accountCashless->no_telp ?? '-' }}</x-tables.td-right-hide>
                        @role('super-admin|manager|supervisor')
                            <x-tables.td-left-hide>{{ $accountCashless->password ?? '-' }}</x-tables.td-left-hide>
                            {{-- <x-tables.td-left-hide>{{ $accountCashless->created_at ?? '-' }}</x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ $accountCashless->updated_at ?? '-' }}</x-tables.td-left-hide> --}}
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $accountCashless)
                                    <a href="{{ route('account-cashlesses.edit', $accountCashless) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan
                                @can('delete', $accountCashless)
                                    <form action="{{ route('account-cashlesses.destroy', $accountCashless) }}"
                                        method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="8"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{{ $accountCashlesses->render() }}</div>
</div>
