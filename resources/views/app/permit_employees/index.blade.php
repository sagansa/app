<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.permit_employees.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">pengajuan izin pegawai</p>
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
                @can('create', App\Models\PermitEmployee::class)
                    <a href="{{ route('permit-employees.create') }}">
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
                <x-tables.th-left-hide>@lang('crud.permit_employees.inputs.reason')
                </x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.permit_employees.inputs.from_date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.permit_employees.inputs.until_date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.permit_employees.inputs.status')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.permit_employees.inputs.created_by_id')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($permitEmployees as $permitEmployee)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($permitEmployee->reason == '1')
                                <span>menikah</span>
                            @elseif ($permitEmployee->reason == '2')
                                <span>sakit</span>
                            @elseif ($permitEmployee->reason == '3')
                                <span>pulkam</span>
                            @elseif ($permitEmployee->reason == '4')
                                <span>libur</span>
                            @elseif ($permitEmployee->reason == '5')
                                <span>keluarga meninggal</span>
                            @elseif ($permitEmployee->reason == '6')
                                <span>lainnya</span>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $permitEmployee->from_date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $permitEmployee->until_date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($permitEmployee->reason == '1')
                                <span>belum disetujui</span>
                            @elseif ($permitEmployee->reason == '2')
                                <span>disetujui</span>
                            @elseif ($permitEmployee->reason == '3')
                                <span>tidak disetujui</span>
                            @elseif ($permitEmployee->reason == '4')
                                <span>pengajuan ulang</span>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($permitEmployee->created_by)->name ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                @if ($permitEmployee->reason == '1')
                                    <span>menikah</span>
                                @elseif ($permitEmployee->reason == '2')
                                    <span>sakit</span>
                                @elseif ($permitEmployee->reason == '3')
                                    <span>pulkam</span>
                                @elseif ($permitEmployee->reason == '4')
                                    <span>libur</span>
                                @elseif ($permitEmployee->reason == '5')
                                    <span>keluarga meninggal</span>
                                @elseif ($permitEmployee->reason == '6')
                                    <span>lainnya</span>
                                @endif
                                {{ $permitEmployee->from_date->toFormattedDate() ?? '-' }} -
                                {{ $permitEmployee->until_date->toFormattedDate() ?? '-' }}
                                @if ($permitEmployee->reason == '1')
                                    <span>belum disetujui</span>
                                @elseif ($permitEmployee->reason == '2')
                                    <span>disetujui</span>
                                @elseif ($permitEmployee->reason == '3')
                                    <span>tidak disetujui</span>
                                @elseif ($permitEmployee->reason == '4')
                                    <span>pengajuan ulang</span>
                                @endif
                            </x-slot>

                        </x-tables.td-left-main>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($permitEmployee->status != '2')
                                    <a href="{{ route('permit-employees.edit', $permitEmployee) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($permitEmployee->status == '2')
                                    <a href="{{ route('permit-employees.show', $permitEmployee) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $permitEmployee)
                                <form action="{{ route('permit-employees.destroy', $permitEmployee) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">@lang('crud.common.no_items_found')</td>
                </tr>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $permitEmployees->render() !!}</div>
</x-admin-layout>
