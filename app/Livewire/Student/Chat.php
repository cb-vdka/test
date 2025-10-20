<?php

namespace App\Livewire\Student;

use App\Models\Chats;
use Livewire\Component;

class Chat extends Component
{
    public $getChatOffier;

    public $newMessage;

    public $allMessages;

    protected $province;

    public function __construct()
    {
        $this->province = new Chats();
    }

    public function mount()
    {
        $this->reload();
    }

    public function reload()
    {
        $this->allMessages = $this->province->getChatDetailByStudent();
    }

    public function sendMessage()
    {
        if ($this->newMessage) {
            $message = $this->province->sendMessage(session('user_id'), $this->newMessage, 2, null);

            $this->allMessages->push($message);

            $this->newMessage = '';
        }
    }

    public function render()
    {
        return view('livewire.student.chat');
    }
}
