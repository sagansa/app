@php $editing = isset($role) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $role->name : '')) }}"
    ></x-input.text>

    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.permissions.name')
        </h4>

        <div class="py-2">
            @foreach ($permissions as $permission)
            <div>
                <x-inputs.checkbox
                    id="permission{{ $permission->id }}"
                    name="permissions[]"
                    label="{{ ucfirst($permission->name) }}"
                    value="{{ $permission->id }}"
                    :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $role->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $role->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($role->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($role->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
