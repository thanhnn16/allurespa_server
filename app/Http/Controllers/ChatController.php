<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(): \Illuminate\Foundation\Application|Factory|View|Application
    {
        $chats = Chat::all();
        $users = User::all();
        return view('pages.chat', ['chats' => $chats, 'users' => $users]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $currentUser = auth()->user();


        $message = Chat::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'sent_at' => $request->sent_at,
        ]);

//        $receiver = User::find($request->receiver_id);
//        $fcmToken = $receiver->fcm_token;
//
//        $data = [
//            'message' => [
//                'token' => $fcmToken,
//                'notification' => [
//                    'title' => 'Tin nhắn mới từ: ' . $currentUser->full_name,
//                    'body' => $request->message,
//                ]
//            ]
//        ];
//
//        $client = new Client();
//        $client->post('https://fcm.googleapis.com/v1/projects/fcm-du-an-1/messages:send', [
//            'headers' => [
//                'Authorization' => 'Bearer ' . $this->getAccessToken(),
//                'Content-Type' => 'application/json'
//            ],
//            'body' => json_encode($data)
//        ]);

        return response()->json($message);
    }

    private function getAccessToken(): string
    {
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();

        return $accessToken['access_token'];
    }

    public function getMessages($userId): JsonResponse
    {
        $currentUser = auth()->user();
        $messages = Chat::with('sender')->where(function ($query) use ($currentUser, $userId) {
            $query->where('sender_id', $currentUser->id)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($currentUser, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $currentUser->id);
        })->orderBy('sent_at', 'asc')->get();
        return response()->json($messages);
    }

}
