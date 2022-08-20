<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.transfer_daily_salaries.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('transfer-daily-salaries.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.transfer_daily_salaries.inputs.image')</x-shows.dt
                        >
                        @if ($transferDailySalary->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a
                            href="{{ \Storage::url($transferDailySalary->image) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $transferDailySalary->image ? \Storage::url($transferDailySalary->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.transfer_daily_salaries.inputs.amount')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $transferDailySalary->amount ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $transferDailySalary->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $transferDailySalary->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('transfer-daily-salaries.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\presence_transfer_daily_salary::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Presences </x-slot>

                <livewire:transfer-daily-salary-presences-detail
                    :transferDailySalary="$transferDailySalary"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
