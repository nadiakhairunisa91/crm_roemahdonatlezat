<!DOCTYPE html>
<thead>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Pelanggan - Roemah Donat Lezat </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        
       
        .chat-header {
        background:rgb(98, 65, 219);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }
    #chat-box {
        height: 250px;
        overflow-y: auto;
        padding: 5px;
        background:rgb(191, 189, 216);
        display: flex;
        flex-direction: column;
    }
    .chat-bubble {
        max-width: 75%;
        padding: 10px;
        border-radius: 10px;
        margin: 5px 0;
    }
    .chat-customer {
        background:rgb(38, 175, 224);
        color: white;
        align-self: flex-end;
    }
    .chat-admin {
        background:rgb(51, 40, 7);
        color: white;
        align-self: flex-start;
    }
    .chat-input-container {
        display: flex;
        padding: 10px;
        background: white;
        border-top: 1px solid #ddd;
    }
    .chat-input {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        outline: none;
        font-size: 14px;
    }
    button {
        padding: 10px 15px;
        margin-left: 10px;
        background:rgb(199, 107, 207);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background:rgb(172, 63, 116);
    }
</style>
    </style>
</thead>
    <div class="chat-header">🍩 Roemah Donat Lezat Chat</div>
    <div id="chat-box"></div>
    <div class="chat-input-container">
        <input type="text" id="isi_chat" class="chat-input" placeholder="Ketik pesan...">
        <button id="send-chat">📩</button>
    </div>

<script>
$(document).ready(function() {
    function loadChat() {
        $.get("chat_load.php", function(data) {
            $("#chat-box").html(data);
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
        });
    }

    loadChat();
    setInterval(loadChat, 3000);

    $("#send-chat").click(function() {
        let isi_chat = $("#isi_chat").val().trim();
        if (isi_chat !== "") {
            $.post("chat_kirim.php", { isi_chat: isi_chat }, function(response) {
                $("#isi_chat").val("");
                loadChat();
            });
        }
    });

    $("#isi_chat").keypress(function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $("#send-chat").click();
        }
    });
});
</script>

</html>
