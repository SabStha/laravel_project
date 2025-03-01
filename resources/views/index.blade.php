@extends('layouts.header')

@section('content')
<div class="container mt-4">
    <div class="chat-container row">
        <!-- Conversations List -->
        <div class="col-md-4">
            <div class="chat-header">Chats</div>
            <div class="chat-list p-3">
                @foreach($conversations as $conversation)
                    <div class="chat-item d-flex justify-content-between align-items-center" 
                         onclick="loadMessages({{ $conversation->id }})">
                        <img src="{{ $conversation->employer_id == auth()->id() ? $conversation->jobseeker->profile_picture : $conversation->employer->profile_picture }}" 
                             onerror="this.src='/default-profile.png';">  
                        <span>
                            {{ $conversation->employer_id == auth()->id() ? $conversation->jobseeker->name : $conversation->employer->name }}
                        </span>
                        @php
                            $unreadCount = $conversation->messages->where('is_read', false)
                                ->where('sender_id', '!=', auth()->id())->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="red-badge">{{ $unreadCount }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="col-md-8 d-flex flex-column">
            <div class="chat-header d-flex justify-content-between">
                <span id="chatTitle">Select a conversation</span>
                <button onclick="deleteConversation()" class="delete-btn"><i class="fas fa-trash-alt"></i></button>
            </div>
            <div class="chat-box d-flex flex-column" id="messages"></div>

            <!-- Chat Input -->
            <div class="chat-footer">
                <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." disabled>
                <button onclick="sendMessage()" class="btn btn-danger ms-2" disabled id="sendBtn">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    let conversationId = null;

    function loadMessages(id) {
        conversationId = id;
        document.getElementById('chatTitle').innerText = 'Chatting...';
        document.getElementById('messageInput').disabled = false;
        document.getElementById('sendBtn').disabled = false;

        fetch(`/chat/messages/${id}`)
            .then(response => response.json())
            .then(messages => {
                let chatBox = document.getElementById('messages');
                chatBox.innerHTML = messages.map(msg => 
                    `<div class="message ${msg.sender_id == {{ auth()->id() }} ? 'sent' : 'received'}">
                        ${msg.message}
                    </div>`).join('');
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    function sendMessage() {
        let message = document.getElementById('messageInput').value;
        if (!message.trim()) return;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ conversation_id: conversationId, message: message })
        }).then(response => response.json())
          .then(msg => {
            document.getElementById('messages').innerHTML += 
                `<div class="message sent">${msg.message}</div>`;
            document.getElementById('messageInput').value = '';
        });
    }
</script>
@endsection
