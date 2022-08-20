<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.utility_usages.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('utility-usages.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.image')</x-shows.dt>
                        @if ($utilityUsage->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($utilityUsage->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $utilityUsage->image ? \Storage::url($utilityUsage->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($utilityUsage->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.utility_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($utilityUsage->utility)->number ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.result')</x-shows.dt>
                        <x-shows.dd>{{ $utilityUsage->result ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $utilityConsumption->status_badge }}">
                                {{ $utilityConsumption->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $utilityUsage->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($utilityUsage->created_by)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.utility_usages.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($utilityUsage->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $utilityUsage->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $utilityUsage->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('utility-usages.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
