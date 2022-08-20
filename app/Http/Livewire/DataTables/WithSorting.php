<?php

namespace App\Http\Livewire\DataTables;

trait WithSorting
{
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    // public $sorts = [];

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
