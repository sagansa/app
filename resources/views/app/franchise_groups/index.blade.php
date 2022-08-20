<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.franchise_groups.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="md:w-1/3">
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
            <div class="text-right md:w-1/3">
                @can('create', App\Models\FranchiseGroup::class)
                    <a href="{{ route('franchise-groups.create') }}">
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
                <x-tables.th-left>@lang('crud.franchise_groups.inputs.name')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.franchise_groups.inputs.status')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.franchise_groups.inputs.user_id')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($franchiseGroups as $franchiseGroup)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $franchiseGroup->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $franchiseGroup->status_badge }}">
                                {{ $franchiseGroup->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($franchiseGroup->user)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('edit', $franchiseGroup)
                                    <a href="{{ route('franchise-groups.edit', $franchiseGroup) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan

                                @can('delete', $franchiseGroup)
                                    <form action="{{ route('franchise-groups.destroy', $franchiseGroup) }}" method="POST"
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
                        <td colspan="4">@lang('crud.common.no_items_found')</td>
                    </tr>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $franchiseGroups->render() !!}</div>
</x-admin-layout>
