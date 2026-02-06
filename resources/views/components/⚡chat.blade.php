<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<!-- resources/views/livewire/chat.blade.php -->

<div>
    <div class="h-96 overflow-y-auto border p-4 space-y-2">
        @foreach($messages as $msg)
            <div>
                <strong>{{ $msg->user->name }}:</strong>
                {{ $msg->body }}
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage" class="mt-4 flex gap-2">
        <input
            wire:model.defer="message"
            type="text"
            class="flex-1 border rounded px-3 py-2"
            placeholder="Type a message..."
        >

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Send
        </button>
    </form>
</div>
