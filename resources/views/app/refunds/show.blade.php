<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.refunds.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('refunds.index') }}" class="mr-4"><i class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.refunds.inputs.image')</x-shows.dt>
                        @if ($refund->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($refund->image) }}">
                                <x-partials.thumbnail src="{{ $refund->image ? \Storage::url($refund->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.refunds.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $refund->status_badge }}">
                                {{ $refund->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.refunds.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $refund->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.refunds.inputs.user_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($refund->user)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $refund->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $refund->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('refunds.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
