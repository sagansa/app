<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.self_consumptions.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('self-consumptions.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.self_consumptions.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($selfConsumption->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.self_consumptions.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $selfConsumption->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Consumption</x-shows.dt>
                        <x-shows.dd>
                            @foreach ($selfConsumption->products as $product)
                                <table>
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>=
                                            @if ($product->pivot->quantity == null)
                                                <x-spans.text-red>0</x-spans.text-red>
                                            @else
                                                <x-spans.text-black>{{ $product->pivot->quantity }}
                                                </x-spans.text-black>
                                            @endif
                                            {{ $product->unit->unit }}
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.self_consumptions.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $selfConsumption->status_badge }}">
                                {{ $selfConsumption->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.self_consumptions.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $selfConsumption->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.self_consumptions.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($selfConsumption->created_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.self_consumptions.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($selfConsumption->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $selfConsumption->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $selfConsumption->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('self-consumptions.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
