@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Chat'])

    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="list-group" style="height: 80vh; overflow-y: auto;">
                    @foreach($users as $user)
                        <a href="#" data-id="{{ $user->id }}" class="list-group-item list-group-item-action">
                            {{ $user->full_name }} <br>
                            {{ $user->phone_number }}
                        </a>
                    @endforeach
                </div>
            </div>
            <!-- Giao diện chat -->
            <div class="col-8">
                <div class="card">
                    <div class="card-body" id="chat-messages" style="height: 70vh; overflow-y: auto;">
                        <h5 class="center text-center m-auto w-100 h-100">Chọn hội thoại</h5>
                    </div>
                    <div class="card-footer">
                        <form id="chat-input">
                            <div class="input-group">
                                <input type="text" id="message-input" class="form-control"
                                       placeholder="Nhập tin nhắn...">
                                <div class="input-group-append">
                                    <button id="send-button" class="btn btn-primary">Gửi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        {{--        --}}
        //        import {initializeApp} from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        //        import {getMessaging, getToken} from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";
        //
        //        const firebaseConfig = {
        //            apiKey: "AIzaSyAGyr8oMsEkv_dKeuSQzgZOeChk4tlJpqI",
        //            authDomain: "fcm-du-an-1.firebaseapp.com",
        //            projectId: "fcm-du-an-1",
        //            storageBucket: "fcm-du-an-1.appspot.com",
        //            messagingSenderId: "316377729414",
        //            appId: "1:316377729414:web:d91c5881b92604f539c407"
        //        };
        //        const app = initializeApp(firebaseConfig);
        //        const messaging = getMessaging(app);
        //        getToken(messaging, {vapidKey: "BHv7ll8dkZ5ChCmVqvrWBa3PAsq95JlDDDmMK4LzYuAEUXXpV0k3Y_RlbC_HMT6VnqMBnxHV6UopmsFUq-lanJU"});
        //

    </script>

    <script>
        console.log(@json($chats));

        $('document').ready(function () {
            $('.list-group-item').click(function () {
                let userId = $(this).data('id');
                $('.list-group-item').removeClass('active');
                $(this).addClass('active');
                $.ajax({
                    url: '/chats/' + userId,
                    method: 'GET',
                    success: function (data) {
                        console.log(data);
                        $('#chat-messages').html('');
                        data.forEach(function (chat) {
                            if (chat.sender.id == {{ auth()->user()->id }}) {
                                $('#chat-messages').append(`
                                <div style="text-align: right;">
                                    <div class="card bg-danger-soft p-2">
                                    <p>${chat.message}</p>
                                    </div>
                                </div>
                            `);
                            } else {
                                $('#chat-messages').append(`
                                <div style="text-align: left;">
                                    <div class="card bg-danger-soft p-2 m-2 w-auto h-auto">
                                    <p><strong>${chat.sender.full_name}</strong>: ${chat.message}</p>
                                    </div>

                                </div>
                            `);
                            }
                        });

                    }
                });
            });

            $('#send-button').click(function (e) {
                e.preventDefault();
                let message = $('#message-input').val();
                let receiverId = $('.list-group-item.active').data('id');
                let sentAt = new Date().toLocaleString();
                $.ajax({
                    url: '/chats/',
                    method: 'POST',
                    data: {
                        message: message,
                        receiver_id: receiverId,
                        sent_at: sentAt
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        console.log(data);
                        $('#chat-messages').append(`
                        <div style="text-align: right;">
                            <p><small>${data.sent_at}</small></p>
                            <p>${data.message}</p>
                        </div>
                    `);

                    }
                });
            });
        });

    </script>
@endsection

