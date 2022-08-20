<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.cleans_and_neats.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('clean-and-neats.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.cleans_and_neats.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($cleanAndNeat->created_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.cleans_and_neats.inputs.left_hand')</x-shows.dt>
                        @if ($cleanAndNeat->left_hand == null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($cleanAndNeat->left_hand) }}">
                                <x-partials.thumbnail
                                    src="{{ $cleanAndNeat->left_hand ? \Storage::url($cleanAndNeat->left_hand) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.cleans_and_neats.inputs.right_hand')</x-shows.dt>
                        @if ($cleanAndNeat->right_hand == null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($cleanAndNeat->right_hand) }}">
                                <x-partials.thumbnail
                                    src="{{ $cleanAndNeat->right_hand ? \Storage::url($cleanAndNeat->right_hand) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.cleans_and_neats.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $cleanAndNeat->status_badge }}">
                                {{ $cleanAndNeat->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created At</x-shows.dt>
                        <x-shows.dd>
                            {{ $cleanAndNeat->created_at }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.cleans_and_neats.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $cleanAndNeat->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('clean-and-neats.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
