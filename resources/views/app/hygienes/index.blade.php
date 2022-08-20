<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.hygienes.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">laporan harian kebersihan warung setiap sisi, dilaksanakan setiap pagi
            sebelum buka setiap hari</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between">
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
            <div class="mt-1 text-right md:w-1/2">
                @can('create', App\Models\Hygiene::class)
                    <a href="{{ route('hygienes.create') }}">
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
                <x-tables.th-left>@lang('crud.hygienes.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.hygienes.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.hygienes.inputs.status')</x-tables.th-left-hide>
                @role('super-admin|manager|supervisor')
                    <x-tables.th-left-hide>@lang('crud.hygienes.inputs.created_by_id')</x-tables.th-left-hide>
                @endrole
                @role('super-admin|manager|staff')
                    <x-tables.th-left-hide>@lang('crud.hygienes.inputs.approved_by_id')</x-tables.th-left-hide>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($hygienes as $hygiene)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main"> {{ optional($hygiene->store)->nickname ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ $hygiene->created_at }}</p>
                                @role('super-admin|manager|supervisor')
                                    <p>created: {{ optional($hygiene->created_by)->name ?? '-' }}</p>
                                @endrole
                                @role('super-admin|manager|staff')
                                    <p>updated: {{ optional($hygiene->approved_by)->name ?? '-' }}</p>
                                @endrole
                                <x-spans.status-valid class="{{ $hygiene->status_badge }}">
                                    {{ $hygiene->status_name }}
                                </x-spans.status-valid>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $hygiene->created_at }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $hygiene->status_badge }}">
                                {{ $hygiene->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        @role('super-admin|manager|supervisor')
                            <x-tables.td-left-hide>
                                {{ optional($hygiene->created_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        @role('super-admin|manager|staff')
                            <x-tables.td-left-hide>
                                {{ optional($hygiene->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($hygiene->status != '2')
                                    <a href="{{ route('hygienes.edit', $hygiene) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($hygiene->status == '2')
                                    <a href="{{ route('hygienes.show', $hygiene) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $hygiene)
                                <form action="{{ route('hygienes.destroy', $hygiene) }}" method="POST"
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
<div class="px-4 mt-10">{!! $hygienes->render() !!}</div>
</x-admin-layout>
