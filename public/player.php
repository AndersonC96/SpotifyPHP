<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/SpotifyAPI.php';
    require '../src/config.php';
    session_start();
    if(!isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }
    $accessToken = $_SESSION['access_token'];
    $spotify = new SpotifyAPI($accessToken);
    $playbackState = $spotify->getPlaybackState();
    $availableDevices = $spotify->getAvailableDevices();
    $currentTrack = $spotify->getCurrentlyPlayingTrack();
    $recentTracks = $spotify->getRecentlyPlayedTracks();
    $userQueue = $spotify->getUsersQueue();
    include 'navbar.php';
?>
<div class="container mx-auto px-4 py-8 mt-16">
    <div class="card mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Player Controls</h2>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Playback State</h3>
            <pre><?php print_r($playbackState); ?></pre>
        </div>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Available Devices</h3>
            <pre><?php print_r($availableDevices); ?></pre>
        </div>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Currently Playing Track</h3>
            <pre><?php print_r($currentTrack); ?></pre>
        </div>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Recently Played Tracks</h3>
            <pre><?php print_r($recentTracks); ?></pre>
        </div>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">User's Queue</h3>
            <pre><?php print_r($userQueue); ?></pre>
        </div>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Controls</h3>
            <button onclick="startPlayback()">Start Playback</button>
            <button onclick="pausePlayback()">Pause Playback</button>
            <button onclick="skipToNext()">Skip to Next</button>
            <button onclick="skipToPrevious()">Skip to Previous</button>
            <button onclick="toggleShuffle(true)">Shuffle On</button>
            <button onclick="toggleShuffle(false)">Shuffle Off</button>
        </div>
    </div>
</div>
<script>
    async function startPlayback(){
        const response = await fetch('control.php?action=start');
        const result = await response.json();
        console.log(result);
    }
    async function pausePlayback(){
        const response = await fetch('control.php?action=pause');
        const result = await response.json();
        console.log(result);
    }
    async function skipToNext(){
        const response = await fetch('control.php?action=next');
        const result = await response.json();
        console.log(result);
    }
    async function skipToPrevious(){
        const response = await fetch('control.php?action=previous');
        const result = await response.json();
        console.log(result);
    }
    async function toggleShuffle(state){
        const response = await fetch(`control.php?action=shuffle&state=${state}`);
        const result = await response.json();
        console.log(result);
    }
</script>