<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.cleans_and_neats.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Laporan Kebersihan dan Kerapian pegawai yang dikerjakan setiap hari jum'at
        </p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between">
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
            <div class="text-right md:w-1/2">
                @can('create', App\Models\CleanAndNeat::class)
                    <a href="{{ route('clean-and-neats.create') }}">
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
                <x-tables.th-left-hide>@lang('crud.cleans_and_neats.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.cleans_and_neats.inputs.left_hand')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.cleans_and_neats.inputs.right_hand')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.cleans_and_neats.inputs.status')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.cleans_and_neats.inputs.created_by_id')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($cleansAndNeats as $cleanAndNeat)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $cleanAndNeat->created_at }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($cleanAndNeat->left_hand == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($cleanAndNeat->left_hand) }}">
                                    <x-partials.thumbnail
                                        src="{{ $cleanAndNeat->left_hand ? \Storage::url($cleanAndNeat->left_hand) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @if ($cleanAndNeat->right_hand == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($cleanAndNeat->right_hand) }}">
                                    <x-partials.thumbnail
                                        src="{{ $cleanAndNeat->right_hand ? \Storage::url($cleanAndNeat->right_hand) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $cleanAndNeat->status_badge }}">
                                {{ $cleanAndNeat->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($cleanAndNeat->created_by)->name ?? '-' }}</x-slot>
                            <x-slot name="sub">{{ $cleanAndNeat->created_at }}
                                <x-spans.status-valid class="{{ $cleanAndNeat->status_badge }}">
                                    {{ $cleanAndNeat->status_name }}
                                </x-spans.status-valid>
                            </x-slot>

                        </x-tables.td-left-main>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($cleanAndNeat->status != '2')
                                    <a href="{{ route('clean-and-neats.edit', $cleanAndNeat) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($cleanAndNeat->status == '2')
                                    <a href="{{ route('clean-and-neats.show', $cleanAndNeat) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $cleanAndNeat)
                                <form action="{{ route('clean-and-neats.destroy', $cleanAndNeat) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="6">
                </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $cleansAndNeats->render() !!}</div>
</div>
