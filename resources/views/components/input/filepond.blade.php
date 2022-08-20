@props(['name', 'label'])

<x-input.partials.group-head>
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}"></x-input.partials.label-desktop>
    <x-input.partials.group class="sm:mt-0 sm:col-span-2">
        @if ($label ?? null)
            @include('components.input.partials.label-mobile')
        @endif

        <div class="mt-1 sm:mt-0 sm:col-span-2" wire:ignore x-data x-init="FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageResize);
        FilePond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
        });
        FilePond.create($refs.input);">
            <input type="file" x-ref="input">
        </div>

        @error($name)
            @include('components.inputs.partials.error')
        @enderror
    </x-input.partials.group>
</x-input.partials.group-head>
