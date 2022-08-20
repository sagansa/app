<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.permit_employees.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('permit-employees.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.permit_employees.inputs.reason')</x-shows.dt>
                        <x-shows.dd>
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
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.permit_employees.inputs.from_date')</x-shows.dt>
                        <x-shows.dd>{{ $permitEmployee->from_date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.permit_employees.inputs.until_date')</x-shows.dt>
                        <x-shows.dd>{{ $permitEmployee->until_date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.permit_employees.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $permitEmployee->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.permit_employees.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            @if ($permitEmployee->status == '1')
                                <span>belum disetujui</span>
                            @elseif ($permitEmployee->status == '2')
                                <span>disetujui</span>
                            @elseif ($permitEmployee->status == '3')
                                <span>tidak disetujui</span>
                            @elseif ($permitEmployee->status == '4')
                                <span>pengajuan ulang</span>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.permit_employees.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($permitEmployee->created_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $permitEmployee->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $permitEmployee->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('permit-employees.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
