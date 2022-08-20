<table>
    @foreach ($utilities as $utility)
        <tr>
            <td>
                <x-input.hidden name="utility_id" value="{{ old('utility_id', $editing ? $utility->id : '') }}">
                </x-input.hidden>
            </td>
            <td>
                <div class="text-xs">{{ $utility->name }} </div>
            </td>
            <td>
                <input
                    class="block w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ $utility->value ?? null }}" data-id="{{ $utility->id }}"
                    name="utilities[{{ $utility->id }}]" type="number" class="utility-quantity form-control">
            </td>
            <td>
                <div class="ml-2 text-xs"> {{ $utility->unit->unit }}</div>
            </td>
        </tr>
    @endforeach
</table>
