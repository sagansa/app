<div>
    <div>
        @can('create', App\Models\WorkingExperience::class)
        <button class="button" wire:click="newWorkingExperience">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\WorkingExperience::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.text
                        name="workingExperience.place"
                        label="Place"
                        wire:model="workingExperience.place"
                        maxlength="255"
                    ></x-input.text>

                    <x-input.text
                        name="workingExperience.position"
                        label="Position"
                        wire:model="workingExperience.position"
                        maxlength="255"
                    ></x-input.text>

                    <x-input.number
                        name="workingExperience.salary_per_month"
                        label="Salary Per Month"
                        wire:model="workingExperience.salary_per_month"
                    ></x-input.number>

                    <x-input.text
                        name="workingExperience.previous_boss_name"
                        label="Previous Boss Name"
                        wire:model="workingExperience.previous_boss_name"
                        maxlength="255"
                    ></x-input.text>

                    <x-input.number
                        name="workingExperience.previous_boss_no"
                        label="Previous Boss No"
                        wire:model="workingExperience.previous_boss_no"
                    ></x-input.number>

                    <x-input.date
                        name="workingExperienceFromDate"
                        label="From Date"
                        wire:model="workingExperienceFromDate"
                        max="255"
                    ></x-input.date>

                    <x-input.date
                        name="workingExperienceUntilDate"
                        label="Until Date"
                        wire:model="workingExperienceUntilDate"
                        max="255"
                    ></x-input.date>

                    <x-input.textarea
                        name="workingExperience.reason"
                        label="Reason"
                        wire:model="workingExperience.reason"
                    ></x-input.textarea>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_working_experiences.inputs.place')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_working_experiences.inputs.position')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.employee_working_experiences.inputs.salary_per_month')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_working_experiences.inputs.previous_boss_name')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.employee_working_experiences.inputs.previous_boss_no')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_working_experiences.inputs.from_date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_working_experiences.inputs.until_date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_working_experiences.inputs.reason')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($workingExperiences as $workingExperience)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $workingExperience->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $workingExperience->place ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $workingExperience->position ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $workingExperience->salary_per_month ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $workingExperience->previous_boss_name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $workingExperience->previous_boss_no ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $workingExperience->from_date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $workingExperience->until_date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $workingExperience->reason ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $workingExperience)
                            <button
                                type="button"
                                class="button"
                                wire:click="editWorkingExperience({{ $workingExperience->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">
                        <div class="mt-10 px-4">
                            {{ $workingExperiences->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
