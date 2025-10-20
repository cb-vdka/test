<?php

namespace App\Livewire\TrainingOfficer;

use App\Models\Chats;
use Livewire\Component;

class Detail extends Component
{
    protected $province;

    public $allMessages;

    public $replyMessage;

    public function __construct()
    {
        $this->province = new Chats();
    }

    public function mount()
    {
        $this->fetchChat();
    }

    public function fetchChat()
    {
        $this->province->updateNotification(session('user_chat_id'), ['is_reply' => 1]);

        $this->allMessages = $this->province->getChatDetail(session('user_chat_id'));
    }

    public function sendMessageTraining()
    {
        if ($this->replyMessage) {
            $message = $this->province->sendMessage(null, $this->replyMessage, 4, session('user_chat_id'));
            $this->allMessages->push($message);
            $this->replyMessage = '';
        }
    }

    public function render()
    {
        return view('livewire.training_officer.detail');
    }
}
