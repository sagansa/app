<div>
    <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
        <x-input.text wire:model.defer="name" name="name" label="Name">
        </x-input.text>

        <x-input.number name="no_telp" label="No Telp" wire:model.defer="no_telp"></x-input.number>

        <x-input.textarea name="address" label="Address" wire:model.defer="address">
        </x-input.textarea>

        @role('super-admin')
            <x-input.select name="province_id" label="Province" wire:model.defer=selectedProvince>
                <option disabled value="null">-- select --</option>
                @foreach ($provinces as $province)
                    {{-- <option value="{{ $value }}">{{ $label }} --}}
                    </option>
                @endforeach
            </x-input.select>

            <x-input.select name="regency_id" label="Regency" wire:model.defer="selectedRegency">
                <option disabled value="null">-- select --</option>
                @foreach ($regencies as $regency)
                    {{-- <option value="{{ $value }}">{{ $label }} --}}
                    </option>
                @endforeach
            </x-input.select>

            <x-input.select name="village_id" label="Village" wire:model.defer="selectedVillage">

                <option disabled value="null">-- select --</option>
                @foreach ($villages as $village)
                    {{-- <option value="{{ $value }}">{{ $label }} --}}
                    </option>
                @endforeach
            </x-input.select>

            <x-input.select name="district_id" label="District" wire:model.defer="selectedDistrict">
                <option disabled value="null">-- select --</option>
                @foreach ($districts as $district)
                    {{-- <option value="{{ $value }}">{{ $label }} --}}
                    </option>
                @endforeach
            </x-input.select>
        @endrole

        <x-input.number name="codepos" label="Codepos" wire:model.defer="codepos"></x-input.number>

        <x-input.select name="bank_id" label="Bank" wire:model.defer="bank_id">
            <option disabled value="null">-- select --</option>
            @foreach ($banks as $value => $label)
                <option value="{{ $value }}">{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.text name="bank_account_name" label="Bank Account Name" wire:model.defer="bank_account_name">
        </x-input.text>

        <x-input.number name="bank_account_no" label="Bank Account No" wire:model.defer="bank_account_no">
        </x-input.number>

        @role('super-admin|manager')
            <x-input.select name="status" label="Status" wire:model.defer="status">
                <option value="1">not verified</option>
                <option value="2">verified</option>
                <option value="3">blacklist</option>
            </x-input.select>
        @endrole

        @role('staff|supervisor')
            <x-input.hidden name="status" value="{{ old('status', $editing ? $supplier->status : '1') }}">
            </x-input.hidden>
        @endrole

        <x-buttons.secondary wire:click="$toggle('showingModal')">@lang('crud.common.cancel')</x-buttons.secondary>
        <x-jet-button wire:click="create">@lang('crud.common.save')</x-jet-button>

        {{-- @if ($editing) --}}
        {{-- <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $supplier->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $supplier->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created By</x-shows.dt>
                <x-shows.dd>{{ optional($supplier->user)->name ?? '-' }}
                </x-shows.dd>
            </x-shows.sub-dl>

        </x-shows.dl> --}}
        {{-- @endif --}}
    </div>
</div>
