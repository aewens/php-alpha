<?php 

class Login {
    public static function isLoggedIn() {
        if (isset($_COOKIE["SNID"])) {
            $check_token = DB::query("SELECT `user_id` FROM `login_tokens` 
                WHERE token=:token", array(":token" => sha1($_COOKIE["SNID"])));
            if ($check_token) {
                $user_id = $check_token[0]["user_id"];
                
                if(isset($_COOKIE["SNID_"])) {
                    return $user_id;
                } else {
                    $cstrong = true;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    DB::query("INSERT INTO `login_tokens` VALUES 
                        (:id, :token, :user_id)",
                        array(":id" => null,
                            ":token" => sha1($token),
                            ":user_id" => $user_id));
                    DB::query("DELETE FROM `login_tokens` WHERE token=:token",
                        array(":token"=>sha1($_COOKIE["SNID"])));
                        
                    # 60 * 60 * 24 * 7 = 604800
                    # 60 * 60 * 24 * 3 = 259200
                    # name, content, expiration, where, domain, ssl, httponly
                    setcookie("SNID", $token, time() + 604800, "/", null, null, 
                        true);
                    setcookie("SNID_", "_", time() + 259200, "/", null, null, 
                        true);
                    
                    return $user_id;
                }
            }
        }
        
        return false;
    }
}
