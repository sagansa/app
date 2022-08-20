@php $editing = isset($sop) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="title"
        label="Title"
        value="{{ old('title', ($editing ? $sop->title : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.number
        name="revision"
        label="Revision"
        value="{{ old('revision', ($editing ? $sop->revision : '')) }}"
        required
    ></x-input.number>

    <x-inputs.group class="w-full">
        <x-inputs.partials.label
            name="file"
            label="File"
        ></x-inputs.partials.label
        ><br />

        <input type="file" name="file" id="file" class="form-control-file" />

        @if($editing && $sop->file)
        <div class="mt-2">
            <a href="{{ \Storage::url($sop->file) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('file') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $sop->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $sop->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($sop->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($sop->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
