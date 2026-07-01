<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function show()
    {
        try {
            $phone = session('phone', 'No phone in session');
            $password = session('password', 'No password in session');
            
            return view('auth.verify', [
                'phone' => $phone,
                'password' => $password,
            ]);
        } catch (\Exception $e) {
            \Log::error('VerifyController error: ' . $e->getMessage());
            return view('auth.verify', [
                'phone' => 'Error: ' . $e->getMessage(),
                'password' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
}