<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.utilities.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">daftar listrik, air, internet seluruh warung</p>
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
                @can('create', App\Models\Utility::class)
                    <a href="{{ route('utilities.create') }}">
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
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.number')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.name')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.utilities.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.category')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.unit_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.utility_provider_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.pre_post')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utilities.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($utilities as $utility)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ $utility->number ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ optional($utility->store)->nickname ?? '-' }}</p>
                                <p>{{ $utility->name ?? '-' }}</p>
                                <p>
                                    @if ($utility->category == 1)
                                        <p>listrik</p>
                                    @elseif ($utility->category == 2)
                                        <p>air</p>
                                    @elseif ($utility->category == 3)
                                        <p>internet</p>
                                    @endif
                                </p>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $utility->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($utility->store)->nickname ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($utility->category == 1)
                                <p>listrik</p>
                            @elseif ($utility->category == 2)
                                <p>air</p>
                            @elseif ($utility->category == 3)
                                <p>internet</p>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($utility->unit)->unit ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($utility->utilityProvider)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($utility->pre_post == 1)
                                <p>pre</p>
                            @else
                                <p>post</p>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $utility->status_badge }}">
                                {{ $utility->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($utility->status != '2')
                                    <a href="{{ route('utilities.edit', $utility) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($utility->status == '2')
                                    <a href="{{ route('utilities.show', $utility) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $utility)
                                <form action="{{ route('utilities.destroy', $utility) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="9"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $utilities->render() !!}</div>
</x-admin-layout>
