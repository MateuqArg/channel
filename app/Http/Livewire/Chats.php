<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;
use Auth;

class Chats extends Component
{
    public $open_chat = false, $new_chat = false, $messages, $message, $selectedChat;

    public $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'messages' => 'array',
        'message' => ''
    ];

    public function mount()
    {
        $this->selectedChat = Chat::query()->where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->first();
    }

    public function render()
    {
        $this->chats = Chat::query()->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id())->get();

        return view('livewire.chat');
    }

    public function getChat($id)
    {
        if ($this->selectedChat->sender->id == Auth::user()->id) {
            $header = $this->selectedChat->receiver->name;
        } else {
            $header = $this->selectedChat->sender->name;
        }

        $this->open_chat = true;
        $this->emit('title', $header);
    }

    public function sendMessage($id)
    {
        $message = new Message([
            'chat_id' => $id,
            'sender_id' => Auth::user()->id,
            'message' => $this->message,
        ]);
        $message->save();

        $this->reset('messages');
        $this->getChat($id);
        $this->reset('message');
    }

    public function getBack()
    {
        $this->open_chat = false;
        $this->new_chat = false;

        $this->emit('title', 'Chat');
    }

    public function getNew()
    {
        $this->new_chat = true;

        $this->emit('title', 'Crear nuevo chat');
    }
}
