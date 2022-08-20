<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.admin_cashlesses.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">seluruh akun admin cashless</p>
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
                @can('create', App\Models\AdminCashless::class)
                    <a href="{{ route('admin-cashlesses.create') }}">
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
                <x-tables.th-left>@lang('crud.admin_cashlesses.inputs.cashless_provider_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.admin_cashlesses.inputs.username')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.admin_cashlesses.inputs.email')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.admin_cashlesses.inputs.no_telp')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.admin_cashlesses.inputs.password')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($adminCashlesses as $adminCashless)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($adminCashless->cashlessProvider)->name ?? '-' }}
                            </x-slot>
                            <x-slot name="sub">
                                <p>username: {{ $adminCashless->username ?? '-' }}</p>
                                <p>email: {{ $adminCashless->email ?? '-' }}</p>
                                <p>no telp: {{ $adminCashless->no_telp ?? '-' }}</p>
                                <p>password: {{ $adminCashless->password ?? '-' }}</p>
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $adminCashless->username ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $adminCashless->email ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-right-hide>{{ $adminCashless->no_telp ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ $adminCashless->password ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">

                                <a href="{{ route('admin-cashlesses.edit', $adminCashless) }}" class="mr-1">
                                    <x-buttons.edit></x-buttons.edit>
                                </a>

                                @can('delete', $adminCashless)
                                    <form action="{{ route('admin-cashlesses.destroy', $adminCashless) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="7"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $adminCashlesses->render() !!}</div>
</x-admin-layout>
