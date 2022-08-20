<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.movement_asset_results.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('movement-asset-results.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.movement_asset_results.inputs.store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($movementAssetResult->store)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.movement_asset_results.inputs.date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $movementAssetResult->date ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.movement_asset_results.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $movementAssetResult->status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.movement_asset_results.inputs.notes')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $movementAssetResult->notes ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.movement_asset_results.inputs.user_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($movementAssetResult->user)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $movementAssetResult->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $movementAssetResult->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('movement-asset-results.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\MovementAssetAudit::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Movement Asset Audits </x-slot>

                <livewire:movement-asset-result-movement-asset-audits-detail
                    :movementAssetResult="$movementAssetResult"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
