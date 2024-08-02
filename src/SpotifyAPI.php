<?php
    class SpotifyAPI{
        private $accessToken;
        public function __construct($accessToken){
            $this->accessToken = $accessToken;
        }
        private function callAPI($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer{$this->accessToken}"
            ]);
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return json_decode($result, true);
        }
        public function getUserData(){
            return $this->callAPI("https://api.spotify.com/v1/me");
        }
        public function getUserPlaylists(){
            return $this->callAPI("https://api.spotify.com/v1/me/playlists");
        }
        public function getRecentlyPlayedTracks(){
            return $this->callAPI("https://api.spotify.com/v1/me/player/recently-played");
        }
        public function playTrack($trackUri){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me/player/play");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PUT, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer{$this->accessToken}",
                "Content-Type: application/json"
            ]);
            $data = json_encode(['uris' => [$trackUri]]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return json_decode($result, true);
        }
    }
?>