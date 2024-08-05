<?php
    class SpotifyAPI{
        private $accessToken;
        public function __construct($accessToken){
            $this->accessToken = $accessToken;
        }
        private function callAPI($url, $method = 'GET', $data = null){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: application/json',
            ]);
            if($data){
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return json_decode($result, true);
        }
        public function getUserData(){
            return $this->callAPI('https://api.spotify.com/v1/me');
        }
        public function getUserPlaylists(){
            return $this->callAPI('https://api.spotify.com/v1/me/playlists');
        }
        public function getRecentlyPlayedTracks(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/recently-played');
        }
        public function getFollowedArtists(){
            return $this->callAPI('https://api.spotify.com/v1/me/following?type=artist');
        }
        public function getUserPodcasts(){
            return $this->callAPI('https://api.spotify.com/v1/me/shows?limit=20');
        }
        public function search($query){
            return $this->callAPI('https://api.spotify.com/v1/search?q=' . urlencode($query) . '&type=track,album,artist&limit=10');
        }
        public function getCurrentlyPlaying(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/currently-playing');
        }
        public function playTrack($trackUri){
            $data = json_encode(['uris' => [$trackUri]]);
            return $this->callAPI('https://api.spotify.com/v1/me/player/play', 'PUT', $data);
        }
        public function getTopTracks(){
            return $this->callAPI('https://api.spotify.com/v1/me/top/tracks?limit=10');
        }
        public function getTopArtists(){
            return $this->callAPI('https://api.spotify.com/v1/me/top/artists?limit=10');
        }
        public function getPlaybackState(){
            return $this->callAPI('https://api.spotify.com/v1/me/player');
        }
        public function transferPlayback($deviceIds){
            return $this->callAPI('https://api.spotify.com/v1/me/player', 'PUT', ['device_ids' => $deviceIds]);
        }
        public function getAvailableDevices(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/devices');
        }
        public function startPlayback($deviceId = null, $contextUri = null, $uris = null){
            $data = [];
            if($deviceId) $data['device_id'] = $deviceId;
            if($contextUri) $data['context_uri'] = $contextUri;
            if($uris) $data['uris'] = $uris;
            return $this->callAPI('https://api.spotify.com/v1/me/player/play', 'PUT', $data);
        }
        public function pausePlayback(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/pause', 'PUT');
        }
        public function skipToNext(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/next', 'POST');
        }
        public function skipToPrevious(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/previous', 'POST');
        }
        public function seekToPosition($positionMs){
            return $this->callAPI('https://api.spotify.com/v1/me/player/seek?position_ms=' . $positionMs, 'PUT');
        }
        public function setRepeatMode($state){
            return $this->callAPI('https://api.spotify.com/v1/me/player/repeat?state=' . $state, 'PUT');
        }
        public function setPlaybackVolume($volumePercent){
            return $this->callAPI('https://api.spotify.com/v1/me/player/volume?volume_percent=' . $volumePercent, 'PUT');
        }
        public function togglePlaybackShuffle($state){
            return $this->callAPI('https://api.spotify.com/v1/me/player/shuffle?state=' . $state, 'PUT');
        }
        public function getUsersQueue(){
            return $this->callAPI('https://api.spotify.com/v1/me/player/queue');
        }
        public function addItemToQueue($uri){
            return $this->callAPI('https://api.spotify.com/v1/me/player/queue?uri=' . $uri, 'POST');
        }
        public function getCurrentlyPlayingTrack(){
            return $this->callAPI("https://api.spotify.com/v1/me/player/currently-playing");
        }
    }