<?php

namespace App\Http\Livewire\DataTables;

trait WithSortingDate
{
    public $sortField = 'date';
    public $sortDirection = 'desc';

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function applySorting($query)
    {
        return $query->orderBy($this->sortColumn, $this->sortDirection);
    }
}
