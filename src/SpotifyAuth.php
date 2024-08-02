<?php
    class SpotifyAuth{
        public static function getAuthUrl(){
            $clientId = CLIENT_ID;
            $redirectUri = REDIRECT_URI;
            $scopes = 'user-read-private user-read-email playlist-read-private user-read-recently-played';
            return "https://accounts.spotify.com/authorize?client_id=$clientId&response_type=code&redirect_uri=$redirectUri&scope=$scopes";
        }
        public static function getAccessToken($code){
            $clientId = CLIENT_ID;
            $clientSecret = CLIENT_SECRET;
            $redirectUri = REDIRECT_URI;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]));
            $headers = [];
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $response = json_decode($result, true);
            if(isset($response['error'])){
                echo 'API Error: ' . $response['error']['message'];
                return null;
            }
            return $response;
        }
    }
?>