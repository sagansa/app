<x-admin-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.account_cashlesses.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\AccountCashless::class)
                    <a href="{{ route('account-cashlesses.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.cashless_provider_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.store_cashless_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.email')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.username')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.no_telp')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.status')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.account_cashlesses.inputs.notes')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($accountCashlesses as $accountCashless)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            {{ optional($accountCashless->cashlessProvider)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($accountCashless->store)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($accountCashless->storeCashless)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->email ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->username ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->no_telp ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->status ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $accountCashless->notes ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($accountCashless->status != '2')
                                    <a href="{{ route('account-cashlesses.edit', $accountCashless) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($accountCashless->status == '2')
                                    <a href="{{ route('account-cashlesses.show', $accountCashless) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $accountCashless)
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
                <x-tables.no-items-found colspan="9"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $accountCashlesses->render() !!}</div> --}}

    <livewire:account-cashlesses.account-cashlesses-list />
</x-admin-layout>
