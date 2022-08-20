<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.movement_asset_results.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}"
                            autocomplete="off"
                        ></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 md:w-1/3 text-right">
                @can('create', App\Models\MovementAssetResult::class)
                <a href="{{ route('movement-asset-results.create') }}"
                    ><x-jet-button>
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')</x-jet-button
                    >
                </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left
                    >@lang('crud.movement_asset_results.inputs.store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.movement_asset_results.inputs.date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.movement_asset_results.inputs.status')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.movement_asset_results.inputs.notes')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.movement_asset_results.inputs.user_id')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($movementAssetResults as $movementAssetResult)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ optional($movementAssetResult->store)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $movementAssetResult->date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $movementAssetResult->status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $movementAssetResult->notes ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($movementAssetResult->user)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($movementAssetResult->status != '2')
                            <a
                                href="{{ route('movement-asset-results.edit', $movementAssetResult) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($movementAssetResult->status == '2')
                            <a
                                href="{{ route('movement-asset-results.show', $movementAssetResult) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $movementAssetResult)
                            <form
                                action="{{ route('movement-asset-results.destroy', $movementAssetResult) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
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
    <div class="mt-10 px-4">{!! $movementAssetResults->render() !!}</div>
</x-admin-layout>
