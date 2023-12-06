@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Chat'])

    <script type="module">
        import {initializeApp} from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        const firebaseConfig = {
            apiKey: "AIzaSyAGyr8oMsEkv_dKeuSQzgZOeChk4tlJpqI",
            authDomain: "fcm-du-an-1.firebaseapp.com",
            projectId: "fcm-du-an-1",
            storageBucket: "fcm-du-an-1.appspot.com",
            messagingSenderId: "316377729414",
            appId: "1:316377729414:web:d91c5881b92604f539c407"
        };

        const app = initializeApp(firebaseConfig);
    </script>
@endsection

