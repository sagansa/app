<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.refunds.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">data seluruh refund karena salah dalam membuat struk</p>
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
                @can('create', App\Models\Refund::class)
                    <a href="{{ route('refunds.create') }}">
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
                <x-tables.th-left>@lang('crud.refunds.inputs.image')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.refunds.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.refunds.inputs.status')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.refunds.inputs.user_id')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($refunds as $refund)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                @if ($refund->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($refund->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $refund->image ? \Storage::url($refund->image) : '' }}" />
                                    </a>
                                @endif
                            </x-slot>
                            <x-slot name="sub">
                                <p> {{ $refund->created_at }}</p>
                                <p> {{ optional($refund->user)->name ?? '-' }}</p>
                                <x-spans.status-valid class="{{ $refund->status_badge }}">
                                    {{ $refund->status_name }}
                                </x-spans.status-valid>
                            </x-slot>

                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>{{ $refund->created_at }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $refund->status_badge }}">
                                {{ $refund->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($refund->user)->name ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($refund->status != '2')
                                    <a href="{{ route('refunds.edit', $refund) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($refund->status == '2')
                                    <a href="{{ route('refunds.show', $refund) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $refund)
                                <form action="{{ route('refunds.destroy', $refund) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="5"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $refunds->render() !!}</div>
</x-admin-layout>
