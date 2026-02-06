<!-- resources/views/livewire/messages-page.blade.php -->

<div class="max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">
        Chat with {{ $receiver->name }}
    </h2>

    <div class="h-96 border overflow-y-auto p-4 space-y-2">
        @foreach($messages as $msg)
            <div class="{{ $msg->user_id === auth()->id() ? 'text-right' : '' }}">
                <span class="font-semibold">
                    {{ $msg->user->name }}
                </span>
                <p>{{ $msg->body }}</p>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage" class="flex gap-2 mt-4">
        <input
            wire:model.defer="body"
            type="text"
            class="flex-1 border rounded px-3 py-2"
            placeholder="Type your message..."
        >

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Send
        </button>
    </form>
</div>

@push('scripts')
<script>
    Echo.private('conversation.{{ $conversation->id }}')
        .listen('.message.sent', (e) => {
            Livewire.dispatch('messageReceived', {
                message: e.message
            });
        });
</script>
@endpush
