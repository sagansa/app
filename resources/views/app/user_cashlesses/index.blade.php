<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.user_cashlesses.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Data seluruh account cashless</p>
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
                @can('create', App\Models\UserCashless::class)
                    <a href="{{ route('user-cashlesses.create') }}">
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

                <x-tables.th-left-hide>Provider</x-tables.th-left-hide>
                <x-tables.th-left>Store</x-tables.th-left>
                @role('super-admin|manager')
                    <x-tables.th-left-hide>Email Admin</x-tables.th-left-hide>
                @endrole
                <x-tables.th-hide>@lang('crud.user_cashlesses.inputs.email') User</x-tables.th-hide>
                <x-tables.th-hide>@lang('crud.user_cashlesses.inputs.username')</x-tables.th-hide>
                <x-tables.th-hide>@lang('crud.user_cashlesses.inputs.no_telp')</x-tables.th-hide>
                @role('super-admin|manager|supervisor')
                    <x-tables.th-left-hide>@lang('crud.user_cashlesses.inputs.password')</x-tables.th-left-hide>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($userCashlesses as $userCashless)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ $userCashless->adminCashless->cashlessProvider->name }}</x-slot>
                            <x-slot name="sub">
                                @role('super-admin|manager')
                                    <p>{{ $userCashless->adminCashless->email }}</p>
                                @endrole
                                <p>store: {{ $userCashless->store->nickname }}</p>
                                <p>email: {{ $userCashless->email ?? '-' }}</p>
                                <p>username: {{ $userCashless->username ?? '-' }}</p>
                                <p>no telp: {{ $userCashless->no_telp ?? '-' }}</p>
                                <p>password: {{ $userCashless->password ?? '-' }}</p>
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>
                            {{ $userCashless->store->nickname }}
                        </x-tables.td-left-hide>
                        @role('super-admin|manager')
                            <x-tables.td-left-hide>
                                {{ $userCashless->adminCashless->email }}
                            </x-tables.td-left-hide>
                        @endrole
                        <x-tables.td-left-hide>{{ $userCashless->email ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $userCashless->username ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-right-hide>{{ $userCashless->no_telp ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ $userCashless->password ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $userCashless)
                                    <a href="{{ route('user-cashlesses.edit', $userCashless) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan
                                @can('delete', $userCashless)
                                    <form action="{{ route('user-cashlesses.destroy', $userCashless) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="6"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $userCashlesses->render() !!}</div>
</x-admin-layout>
