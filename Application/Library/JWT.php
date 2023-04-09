<?php
namespace SekiXu\SampleRouter\Application\Library;

use SekiXu\SampleRouter\Application\Library\Util;

class JWT {
    private static $secret = null;

    public static function set_secret(string $secret){
        self::$secret = $secret;
    }

    public static function sign($payload){
        $key = md5(self::$secret);
        $header = Util::secure_base64_encode(json_encode([
            "typ" => "JWT",
            "alg" => "HS256"
        ]));
        // time() + 3600 = 1 hour vaild
        $payload["exp"] = time() + 3600;
        $payload = Util::secure_base64_encode(json_encode($payload));
        $signature = Util::secure_base64_encode(hash_hmac("sha256", "$header.$payload", $key, true));
        return "$header.$payload.$signature";
    }

    public static function verify($token){
        $key = md5(self::$secret);
        $tokens = explode(".", $token);
        if(count($tokens) !== 3){
            return false;
        }
        [$header, $payload, $signature] = $tokens;
        $right_signature = Util::secure_base64_encode(hash_hmac("sha256", "$header.$payload", $key, true));
        return $signature === $right_signature && self::get_payload($token)["exp"] > time();
    }

    public static function get_payload($token){
        $tokens = explode(".", $token);
        if(count($tokens) !== 3){
            return false;
        }
        [$header, $payload, $signature] = $tokens;
        return json_decode(Util::secure_base64_decode($payload), true);
    }
}