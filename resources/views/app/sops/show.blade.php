<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.standard_operation_procedures.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('sops.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.standard_operation_procedures.inputs.title')</x-shows.dt
                        >
                        <x-shows.dd>{{ $sop->title ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.standard_operation_procedures.inputs.revision')</x-shows.dt
                        >
                        <x-shows.dd>{{ $sop->revision ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.standard_operation_procedures.inputs.file')</x-shows.dt
                        >
                        @if($sop->file)
                        <a href="{{ \Storage::url($sop->file) }}" target="blank"
                            ><i class="mr-1 icon ion-md-download"></i
                            >&nbsp;Download</a
                        >
                        @else - @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $sop->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $sop->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('sops.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
