<?php

use App\Models\RequestHardwareSoftware;

if(!function_exists('generateUniqueCode')) {
    function generateUniqueCode() {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }

        if (RequestHardwareSoftware::where('unique_request', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }
}