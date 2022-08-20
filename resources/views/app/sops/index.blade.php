<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.standard_operation_procedures.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}"
                            autocomplete="off"
                        ></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 md:w-1/3 text-right">
                @can('create', App\Models\Sop::class)
                <a href="{{ route('sops.create') }}"
                    ><x-jet-button>
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')</x-jet-button
                    >
                </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left
                    >@lang('crud.standard_operation_procedures.inputs.title')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.standard_operation_procedures.inputs.revision')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.standard_operation_procedures.inputs.file')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($sops as $sop)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ $sop->title ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $sop->revision ?? '-' }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide
                        >@if($sop->file)
                        <a href="{{ \Storage::url($sop->file) }}" target="blank"
                            ><i class="mr-1 icon ion-md-download"></i
                            >&nbsp;Download</a
                        >
                        @else - @endif</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($sop->status != '2')
                            <a
                                href="{{ route('sops.edit', $sop) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($sop->status == '2')
                            <a
                                href="{{ route('sops.show', $sop) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $sop)
                            <form
                                action="{{ route('sops.destroy', $sop) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                                <x-buttons.delete></x-buttons.delete>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <x-tables.no-items-found colspan="4"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $sops->render() !!}</div>
</x-admin-layout>
