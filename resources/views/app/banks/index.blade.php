<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.banks.index_title')
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
                @can('create', App\Models\Bank::class)
                    <a href="{{ route('banks.create') }}">
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
                <x-tables.th-left>@lang('crud.banks.inputs.name')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.banks.inputs.status')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($banks as $bank)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $bank->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $bank->status_badge }}">
                                {{ $bank->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('edit', $bank)
                                    <a href="{{ route('banks.edit', $bank) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan
                                @can('delete', $bank)
                                    <form action="{{ route('banks.destroy', $bank) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('crud.common.no_items_found')</td>
                    </tr>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $banks->render() !!}</div>
</x-admin-layout>
