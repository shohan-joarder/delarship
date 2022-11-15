<?php

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('decodeToken')) {
    function decodeToken($token)
    {
        $decode = JWT::decode($token, new Key(env('JWT_KEY'), env('JWT_ALGO')));
        return $decode;
    }
}
