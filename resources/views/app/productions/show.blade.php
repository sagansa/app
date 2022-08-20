<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.productions.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('productions.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.productions.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($production->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.productions.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $production->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>To Product</x-shows.dt>
                        <x-shows.dd>{{ optional($production->product)->name ?? '-' }} =
                            {{ $production->quantity ?? '-' }} {{ $production->product->unit->unit }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>From Product</x-shows.dt>
                        <x-shows.dd>
                            @foreach ($production->products as $product)
                                <div>
                                    {{ $product->name }} = {{ $product->pivot->quantity }}
                                    {{ $product->unit->unit }}
                                </div>
                            @endforeach
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    {{-- <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.productions.inputs.quantity')</x-shows.dt>
                        <x-shows.dd>{{ $production->quantity ?? '-' }} {{ $production->product->unit->unit }}
                        </x-shows.dd>
                    </x-shows.sub-dl> --}}
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.productions.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $production->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.productions.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $production->status_badge }}">
                                {{ $production->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.productions.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($production->created_by)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.productions.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($production->approved_by)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $production->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $production->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('productions.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\Production::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Products </x-slot>

                    <livewire:production-products-detail :production="$production" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
