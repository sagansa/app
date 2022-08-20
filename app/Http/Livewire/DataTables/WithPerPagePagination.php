<?php

namespace App\Http\Livewire\DataTables;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    public $perPage = 10;

    public function initializeWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }

    public function applyPagination($query)
    {
        return $query->paginate($this->perPage);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }
}
