<?php

namespace App\Http\Livewire\DataTables;

trait WithFilter
{
    public $showFilters = false;

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public $showDetails = false;
}
