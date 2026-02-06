@push('scripts')
<script>
    Echo.channel('chat-room')
        .listen('.message.sent', (e) => {
            Livewire.dispatch('messageReceived', {
                message: e.message
            });
        });
</script>
@endpush

