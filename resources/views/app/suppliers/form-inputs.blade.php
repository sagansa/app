@php $editing = isset($supplier) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $supplier->name : '') }}" required>
    </x-input.text>

    <x-input.number name="no_telp" label="No Telp" value="{{ old('no_telp', $editing ? $supplier->no_telp : '') }}">
    </x-input.number>

    <x-input.textarea name="address" label="Address">{{ old('address', $editing ? $supplier->address : '') }}
    </x-input.textarea>

    @role('super-admin')
        <x-input.select name="province_id" label="Province">
            @php $selected = old('province_id', ($editing ? $supplier->province_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($provinces as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </x-input.select>

        <x-input.select name="regency_id" label="Regency">
            @php $selected = old('regency_id', ($editing ? $supplier->regency_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            {{-- @foreach ($regencies as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach --}}
        </x-input.select>

        <x-input.select name="village_id" label="Village">
            @php $selected = old('village_id', ($editing ? $supplier->village_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            {{-- @foreach ($villages as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach --}}
        </x-input.select>

        <x-input.select name="district_id" label="District">
            @php $selected = old('district_id', ($editing ? $supplier->district_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            {{-- @foreach ($districts as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach --}}
        </x-input.select>
    @endrole

    <x-input.number name="codepos" label="Codepos" value="{{ old('codepos', $editing ? $supplier->codepos : '') }}">
    </x-input.number>

    <x-input.select name="bank_id" label="Bank">
        @php $selected = old('bank_id', ($editing ? $supplier->bank_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($banks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.text name="bank_account_name" label="Bank Account Name"
        value="{{ old('bank_account_name', $editing ? $supplier->bank_account_name : '') }}" maxlength="255">
    </x-input.text>

    <x-input.number name="bank_account_no" label="Bank Account No"
        value="{{ old('bank_account_no', $editing ? $supplier->bank_account_no : '') }}"></x-input.number>

    @role('super-admin|manager')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $supplier->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>not verified</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>verified</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>blacklist</option>
        </x-input.select>
    @endrole

    @role('staff|supervisor')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $supplier->status : '1') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        <x-shows.dl>
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

        </x-shows.dl>
    @endif
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X_CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $(document).ready(function() {
        $("#province_id").change(function() {
            var province_id = $($this).val();

            if (province_id == "") {
                var province_id = 0;
            }

            $.ajax({
                url: '{{ url('/fetch-regencies/') }}' + village_id,
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $('#regency').fund('option.not(:first)').remove();
                    $('#village').fund('option.not(:first)').remove();
                    $('#district').fund('option.not(:first)').remove();

                    if (response['regencies'].length > 0) {
                        $.each(response['regencies'], function(key, value) {
                            $("#regency").append("<option value='" + value['id'] +
                                "'>" + value['name'] + "</option>")
                        });
                    }
                }
            })
        });

        $("#regency_id").change(function() {
            var regency_id = $($this).val();

            if (regency_id == "") {
                var regency_id = 0;
            }

            $.ajax({
                url: '{{ url('/fetch-villages/') }}' + regency_id,
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $('#village').fund('option.not(:first)').remove();
                    $('#district').fund('option.not(:first)').remove();

                    if (response['villages'].length > 0) {
                        $.each(response['villages'], function(key, value) {
                            $("#village").append("<option value='" + value['id'] +
                                "'>" + value['name'] + "</option>")
                        });
                    }
                }
            })
        });

        $("#village_id").change(function() {
            var village_id = $($this).val();

            if (village_id == "") {
                var village_id = 0;
            }

            $.ajax({
                url: '{{ url('/fetch-districts/') }}' + village_id,
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $('#district').fund('option.not(:first)').remove();

                    if (response['districts'].length > 0) {
                        $.each(response['districts'], function(key, value) {
                            $("#district").append("<option value='" + value['id'] +
                                "'>" + value['name'] + "</option>")
                        });
                    }
                }
            })
        });
    });
</script>
