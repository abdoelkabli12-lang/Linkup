<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Events\MessageSent;
use App\Events\PrivateMessageSent;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessagesPage extends Component
{
  public $conversation;
  public string $body = '';
  public $messages;
  public $reciever;

  protected $rules = [
    'body' => 'required|string|max:1000',
  ];

  protected $listeners = ['messageReceived'];

public function messageReceived($payload)
{
    $this->messages->push($payload['message']);
}


  public function mount(User $user){
    $this->reciever = $user;

    $this->conversation = Conversation::firstOrCreate(
      [
        'user_one' => min(Auth::id(), $user->id),
        'uset_two' => max(Auth::id(), $user->id)
      ]
    );

    $this->messages = $this->conversation->messages
    ->with('user')
    ->get();
  }

  public function sendMessage(){
    $this->validate();

    $message = Message::create([
      'conversation_id' => $this->conversation->id,
      'user_id' => Auth::id(),
      'body' => $this->message
    ]);

    broadcast(new PrivateMessageSent($message))->toOthers();

    $this->messages->push($message->load('user'));

    $this->reset('body');
  }

  public function render(){
    return view('livewire.chat');
  }

}