<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/SpotifyAPI.php';
    require '../src/config.php';
    session_start();
    if(!isset($_SESSION['access_token'])){
        echo json_encode(['error' => 'Not authenticated']);
        exit();
    }
    $accessToken = $_SESSION['access_token'];
    $spotify = new SpotifyAPI($accessToken);
    $action = $_GET['action'] ?? null;
    $response = [];
    switch($action){
        case 'start':
            $response = $spotify->startPlayback();
            break;
        case 'pause':
            $response = $spotify->pausePlayback();
            break;
        case 'next':
            $response = $spotify->skipToNext();
            break;
        case 'previous':
            $response = $spotify->skipToPrevious();
            break;
        case 'shuffle':
            $state = $_GET['state'] ?? false;
            $response = $spotify->togglePlaybackShuffle($state);
            break;
        default:
            $response = ['error' => 'Invalid action'];
    }
    echo json_encode($response);