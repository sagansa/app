<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.suppliers.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">daftar seluruh pemasok</p>
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
                @can('create', App\Models\Supplier::class)
                    <a href="{{ route('suppliers.create') }}">
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
                <x-tables.th-left>@lang('crud.suppliers.inputs.name')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.suppliers.inputs.no_telp')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.suppliers.inputs.bank_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.suppliers.inputs.bank_account_name')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.suppliers.inputs.bank_account_no')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.suppliers.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ $supplier->name ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ $supplier->no_telp ?? '-' }}</p>
                                <p>{{ optional($supplier->bank)->name ?? '-' }}</p>
                                <p>{{ $supplier->bank_account_name ?? '-' }}</p>
                                <p>{{ $supplier->bank_account_no ?? '-' }}</p>
                                <p>
                                    @if ($supplier->status == 1)
                                        <x-spans.yellow>not verified</x-spans.yellow>
                                    @elseif ($supplier->status == 2)
                                        <x-spans.green>verified</x-spans.green>
                                    @elseif ($supplier->status == 3)
                                        <x-spans.red>blacklist</x-spans.red>
                                    @elseif ($supplier->status == 4)
                                        <x-spans.gray>submitted</x-spans.gray>
                                    @endif
                                </p>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-right-hide>{{ $supplier->no_telp ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ optional($supplier->bank)->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $supplier->bank_account_name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-right-hide>{{ $supplier->bank_account_no ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>
                            @if ($supplier->status == 1)
                                <x-spans.yellow>not verified</x-spans.yellow>
                            @elseif ($supplier->status == 2)
                                <x-spans.green>verified</x-spans.green>
                            @elseif ($supplier->status == 3)
                                <x-spans.gray>blacklist</x-spans.gray>
                            @endif
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $supplier)
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan
                                {{-- @elseif($supplier->status == '2')
                                    <a href="{{ route('suppliers.show', $supplier) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif --}}
                                @can('delete', $supplier)
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
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
    <div class="px-4 mt-10">{!! $suppliers->render() !!}</div>
</x-admin-layout>
