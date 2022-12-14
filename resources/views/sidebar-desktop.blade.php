<div class="hidden xl:flex xl:w-64 xl:flex-col xl:fixed xl:inset-y-0">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white border-r border-gray-200">
        <div class="flex items-center flex-shrink-0 px-4">
            <img class="w-auto h-8" src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg"
                alt="Workflow">
        </div>
        <div class="flex flex-col flex-grow mt-5">
            @include('layouts.menu-desktop')
        </div>
    </div>
</div>
