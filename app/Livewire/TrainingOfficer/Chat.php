<?php

namespace App\Livewire\TrainingOfficer;

use App\Models\Chats;
use Livewire\Component;

class Chat extends Component
{
    protected $province;

    public $getAllChat;

    public $searchTerm = '';

    public function __construct()
    {
        $this->province = new Chats();
    }

    public function mount()
    {
        if (empty($this->searchTerm)) {
            $this->fetchList();
        }
    }

    public function fetchList()
    {
        $this->getAllChat = $this->province->getAllChat();
    }

    public function render()
    {
        $this->getAllChat = $this->province->getAllChat($this->searchTerm);
        return view('livewire.training_officer.chat');
    }
}
