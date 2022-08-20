<?php

namespace App\Http\Livewire\DataTables;

use Illuminate\Support\Facades\Auth;

trait WithModal
{
    public $showEditModal = false;

    public function save()
    {
        $this->validate();

        $this->editing->save();

        $this->showEditModal = false;
    }
}
