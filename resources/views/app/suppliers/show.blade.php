<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.suppliers.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('suppliers.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.name')</x-shows.dt
                        >
                        <x-shows.dd>{{ $supplier->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.no_telp')</x-shows.dt
                        >
                        <x-shows.dd>{{ $supplier->no_telp ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.address')</x-shows.dt
                        >
                        <x-shows.dd>{{ $supplier->address ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.province_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($supplier->province)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.regency_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($supplier->regency)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.village_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($supplier->village)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.district_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($supplier->district)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.codepos')</x-shows.dt
                        >
                        <x-shows.dd>{{ $supplier->codepos ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.bank_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($supplier->bank)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.bank_account_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $supplier->bank_account_name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.bank_account_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $supplier->bank_account_no ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.suppliers.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd>{{ $supplier->status ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $supplier->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $supplier->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('suppliers.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
