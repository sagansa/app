<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.products.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">daftar seluruh produk</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click.prevent="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                <x-filters.group>
                    <x-filters.label>Payment Type</x-filters.label>
                    <x-filters.select wire:model="filters.payment_type_id">
                        @foreach ($paymentTypes as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Product Group</x-filters.label>
                    <x-filters.select wire:model="filters.product_group_id">
                        @foreach ($productGroups as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Material Group</x-filters.label>
                    <x-filters.select wire:model="filters.material_group_id">
                        @foreach ($materialGroups as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Franchise Group</x-filters.label>
                    <x-filters.select wire:model="filters.franchise_group_id">
                        @foreach ($franchiseGroups as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Online Category</x-filters.label>
                    <x-filters.select wire:model="filters.online_category_id">
                        @foreach ($onlineCategories as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Restaurant Category</x-filters.label>
                    <x-filters.select wire:model="filters.restaurant_category_id">
                        @foreach ($restaurantCategories as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Request</x-filters.label>
                    <x-filters.select wire:model="filters.request">
                        @foreach (App\Models\Product::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Remaining</x-filters.label>
                    <x-filters.select wire:model="filters.remaining">
                        @foreach (App\Models\Product::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">

                </div>
                <div class="mt-1 text-right md:w-1/3">
                    @can('create', App\Models\Product::class)
                        <x-jet-button wire:click="newProduct">
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                        </a>
                    @endcan
                </div>
            </div>
        </x-slot>

    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.products.inputs.image')</x-tables.th-left>
                <x-tables.th-left wire:click="sortByColumn('name')">
                    <x-spans.sort>@lang('crud.products.inputs.name')
                        @if ($sortColumn == 'name')
                            @include('svg.sort-' . $sortDirection)
                        @else
                            @include('svg.sort')
                        @endif
                    </x-spans.sort>
                </x-tables.th-left>
                <x-tables.th-left>@lang('crud.products.inputs.unit_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.products.inputs.material_group_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.products.inputs.payment_type_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.products.inputs.product_group_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.products.inputs.request')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.products.inputs.remaining')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($product->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($product->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $product->image ? \Storage::url($product->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>{{ $product->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($product->unit)->unit ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($product->materialGroup)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($product->paymentType)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($product->productGroup)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $product->request_badge }}">
                                {{ $product->request_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $product->remaining_badge }}">
                                {{ $product->remaining_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $product)
                                    <x-buttons.edit wire:click="editProduct({{ $product->id }})">
                                    </x-buttons.edit>
                                @endcan
                                @can('delete', $product)
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
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
    <div class="px-4 mt-10">{!! $products->render() !!}</div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                <x-input.image name="productImage" label="Image">
                    <div image-url="{{ $editing && $product->image ? \Storage::url($product->image) : '' }}"
                        x-data="imageViewer()" @refresh.window="refreshUrl()" class="mt-1 sm:mt-0 sm:col-span-2">
                        <!-- Show the image -->
                        <template x-if="imageUrl">
                            <img :src="imageUrl" class="object-cover border border-gray-200 rounded "
                                style="width: 100px; height: 100px;" />
                        </template>

                        <!-- Show the gray box when image is not available -->
                        <template x-if="!imageUrl">
                            <div class="bg-gray-100 border border-gray-200 rounded "
                                style="width: 100px; height: 100px;"></div>
                        </template>

                        <div class="mt-2">
                            <input type="file" name="productImage" id="productImage{{ $uploadIteration }}"
                                wire:model="productImage" @change="fileChosen" />
                        </div>

                        @error('productImage')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image>

                <x-input.text name="product.name" label="Name" wire:model="product.name" maxlength="255">
                </x-input.text>

                <x-input.text name="product.slug" label="Slug" wire:model="product.slug" maxlength="50">
                </x-input.text>

                <x-input.text name="product.sku" label="SKU" wire:model="product.sku" maxlength="255">
                </x-input.text>

                <x-input.text name="product.barcode" label="Barcode" wire:model="product.barcode" maxlength="255">
                </x-input.text>

                <x-input.textarea name="product.description" label="Description" wire:model="product.description"
                    maxlength="255"></x-input.textarea>

                <x-input.select name="product.unit_id" label="Unit" wire:model="product.unit_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($units as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.material_group_id" label="Material Group"
                    wire:model="product.material_group_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($materialGroups as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.franchise_group_id" label="Franchise Group"
                    wire:model="product.franchise_group_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($franchiseGroups as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.payment_type_id" label="Payment Type"
                    wire:model="product.payment_type_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($paymentTypes as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.online_category_id" label="Online Category"
                    wire:model="product.online_category_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($onlineCategories as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.product_group_id" label="Product Group"
                    wire:model="product.product_group_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productGroups as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.restaurant_category_id" label="Restaurant Category"
                    wire:model="product.restaurant_category_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($restaurantCategories as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="product.remaining" label="Remaining" wire:model="product.remaining">
                    <option value="1" {{ $selected == '1' ? 'selected' : '' }}>active</option>
                    <option value="2" {{ $selected == '2' ? 'selected' : '' }}>inactive</option>
                </x-input.select>

                <x-input.select name="product.request" label="Request" wire:model="product.request">
                    <option value="1" {{ $selected == '1' ? 'selected' : '' }}>active</option>
                    <option value="2" {{ $selected == '2' ? 'selected' : '' }}>inactive</option>
                </x-input.select>

            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">


            <x-buttons.secondary wire:click="$toggle('showingModal')"> @lang('crud.common.cancel')</x-buttons.secondary>
            <x-jet-button wire:click="save"> @lang('crud.common.save')</x-jet-button>
        </div>
    </x-modal>
</div>
