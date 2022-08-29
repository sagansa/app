<div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-lg">
    <table class="min-w-full divide-y divide-cool-gray-200">
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>
        <tbody wire:loading.class="text-muted" class="bg-white divide-y divide-cool-gray-200">
            {{ $body }}
        </tbody>
        <tfoot>
            {{ $foot }}
        </tfoot>
    </table>
</div>


{{-- <table class="min-w-full border-separate" style="border-spacing: 0">
    <thead>
        <tr>
            {{ $head }}
        </tr>
    </thead>
    <tbody wire:loading.class="text-muted" class="bg-white divide-y divide-cool-gray-200">
        {{ $body }}
    </tbody>
    <tfoot>
        {{ $foot }}
    </tfoot>
</table> --}}
