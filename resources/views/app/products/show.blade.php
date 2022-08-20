<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.products.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('products.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.barcode')</x-shows.dt
                        >
                        @if ($product->barcode != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($product->barcode) }}">
                            <x-partials.thumbnail
                                src="{{ $product->barcode ? \Storage::url($product->barcode) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.image')</x-shows.dt
                        >
                        @if ($product->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($product->image) }}">
                            <x-partials.thumbnail
                                src="{{ $product->image ? \Storage::url($product->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.name')</x-shows.dt
                        >
                        <x-shows.dd>{{ $product->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.slug')</x-shows.dt
                        >
                        <x-shows.dd>{{ $product->slug ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.sku')</x-shows.dt
                        >
                        <x-shows.dd>{{ $product->sku ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.description')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $product->description ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.unit_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->unit)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.material_group_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->materialGroup)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.franchise_group_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->franchiseGroup)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.payment_type_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->paymentType)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.online_category_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->onlineCategory)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.product_group_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->productGroup)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.restaurant_category_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($product->restaurantCategory)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.request')</x-shows.dt
                        >
                        <x-shows.dd>{{ $product->request ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.products.inputs.remaining')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $product->remaining ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $product->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $product->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('products.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
