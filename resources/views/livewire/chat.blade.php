<div>
<a data-bs-toggle="modal" data-bs-target="#chat" class="btn btn-warning btn-chat text-white" href=""><i class="bi bi-chat"></i></a>

<div class="modal fade" wire:ignore.self id="chat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable chat">
    <div class="modal-content chat">
      <div class="modal-header">
        <h5 class="modal-title" wire:ignore id="header">Chat</h5>
        <button type="button" class="btn btn-outline-secondary" wire:click="getBack"><i class="bi bi-arrow-left"></i></button>
      </div>
      <div class="modal-body p-0" style="overflow-x: hidden;">
        <div class="row row-cols-1">
            @if($open_chat == false)
            <div class="m-3 mb-0">
            @foreach($chats as $chat)
                <a wire:click="getChat({{ $chat->id }})" id="{{ $chat->id }}" class="text-dark text-decoration-none" style="cursor: pointer;">
                <div class="col mb-2 d-flex">
                    <img src="https://github.com/mdo.png" width="50" height="50" class="rounded-circle">
                    <div class="ms-2">
                        <h6 class="mb-0">{{ $chat->receiver->name }}</h6>
                        <p class="mb-0 thumbnail-message"><i class="bi bi-envelope-open"></i> {{ $chat->last_message->message }}</p>
                    </div>
                </div>
                </a>
            @endforeach
            </div>
            <hr>
            @elseif($open_chat == true)
            <div wire:poll>
                <div class="m-2 mt-1 mb-1">
                    @foreach($selectedChat->messages as $message)
                    @if($message->sender->id == \Auth::user()->id)
                        <div class="col mb-2 d-flex ps-1">
                            <p class="ms-auto mb-0 p-2 msg-sender rounded-start"><small>[{{ $message->created_at->format('g:i a') }}]</small> {{ $message->message }}</p>
                        </div>
                    @else
                        <div class="col mb-2 d-flex ps-1">
                            <p class="mb-0 p-2 msg-receiver rounded-end"><small>[{{ $message->created_at->format('g:i a') }}]</small> {{ $message->message }}</p>
                        </div>
                    @endif
                    @endforeach
                </div>
                <div class="col d-flex p-1 m-0 msg-input">
                    <div class="input-group bg-white">
                      <input type="text" class="form-control" placeholder="Escribe un mensaje..." aria-describedby="send-btn" wire:model="message" wire:keydown.enter="sendMessage({{ $message->chat_id }})" id="message" value="message">
                      <button class="btn btn-outline-success" wire:click="sendMessage({{ $message->chat_id }})" type="button" id="send-btn"><i class="bi bi-send"></i></button>
                    </div>
                </div>
            </div>
            @endif
        </div>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="create" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div> --}}
    </div>
  </div>
</div>

<script>
    window.livewire.on('title', event => {
      $("#header").text(event);
    })
</script>
</div>