@if ($outInProduct->status != 2)
    <x-admin-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.out_in_products.edit_title')
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('out-in-products.index') }}" class="mr-4"><i
                                class="mr-1 icon ion-md-arrow-back"></i></a>
                    </x-slot>

                    <x-form method="PUT" action="{{ route('out-in-products.update', $outInProduct) }}" has-files
                        class="mt-4">
                        @include('app.out_in_products.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('out-in-products.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <x-jet-button class="float-right">
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.update')
                            </x-jet-button>
                        </div>
                    </x-form>
                </x-partials.card>

                @can('view-any', App\Models\OutInProduct::class)
                    <x-partials.card class="mt-5">
                        <x-slot name="title"> Products </x-slot>

                        <livewire:out-in-product-products-detail :outInProduct="$outInProduct" />
                    </x-partials.card>
                @endcan
            </div>
        </div>
    </x-admin-layout>
@else
    <x-admin-layout>
        <a href="{{ route('out-in-products.index') }}" class="button">
            <i class="mr-1 icon ion-md-return-left text-primary"></i>
            FORBIDDEN ACCESS @lang('crud.common.back')
        </a>
    </x-admin-layout>
@endif
