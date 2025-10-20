<?php

namespace App\Livewire;

use App\Models\Classes;
use Livewire\Component;

class SearchClass extends Component
{
    public $search = '';

    public function render()
    {
        return view('', [
            'users' => Classes::search($this->search),
        ]);
    }
}
