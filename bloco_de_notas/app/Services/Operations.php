<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Operations
{
    public static function decrypt($value)
    {
        // check if $value is encrypted
        try {
            return Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }
        return $value;
    }
}
