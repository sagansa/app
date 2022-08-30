@php $editing = isset($utilityUsage) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $utilityUsage->image ? \Storage::url($utilityUsage->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-cover border border-gray-200 rounded"
                    style="width: 100px; height: 100px;" />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div class="bg-gray-100 border border-gray-200 rounded" style="width: 100px; height: 100px;"></div>
            </template>
            @role('staff|super-admin')
                <div class="mt-2">
                    <input type="file" name="image" id="image" @change="fileChosen" />
                </div>
            @endrole
            @error('image')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select id="utility_id" name="utility_id" label="Utility" required>
        @php $selected = old('utility_id', ($editing ? $utilityUsage->utility_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($utilities as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.number name="result" label="Result" value="{{ old('result', $editing ? $utilityUsage->result : '') }}"
        required></x-input.number>


    @if ($editing)
        @role('manager|super-admin')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $utilityUsage->status : '1')) @endphp
                <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('staff|supervisor')
            @if ($utilityUsage->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $utilityUsage->status : '1')) @endphp
                    <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $utilityUsage->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole
    @endif

    @if (!$editing)
        <x-input.hidden name="status" value="{{ old('status', $editing ? $utilityUsage->status : '1') }}">
        </x-input.hidden>
    @endif

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $utilityUsage->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            @role('supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.utility_usages.inputs.store_id')</x-shows.dt>
                    <x-shows.dd>
                        {{ optional($utilityUsage->store)->nickname ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.utility_usages.inputs.utility_id')</x-shows.dt>
                    <x-shows.dd>
                        {{ optional($utilityUsage->utility)->number ?? '-' }} -
                        @if ($utilityUsage->utility->category == 1)
                            <span>internet</span>
                        @elseif ($utilityUsage->utility->category == 2)
                            <span>listrik</span>
                        @elseif ($utilityUsage->utility->category == 3)
                            <span>air</span>
                        @endif
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.utility_usages.inputs.result')</x-shows.dt>
                    <x-shows.dd>{{ $utilityUsage->result ?? '-' }}
                        {{ $utilityUsage->utility->unit->unit ?? '-' }}</x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $utilityUsage->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $utilityUsage->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($utilityUsage->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($utilityUsage->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
