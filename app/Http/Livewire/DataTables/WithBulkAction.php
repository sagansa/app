<?php

namespace App\Http\Livewire\DataTables;

trait WithBulkAction
{
    public $selectedRows = [];

    public function getSelectedCountProperty()
    {
        return count($this->selectedRows);
    }
}
