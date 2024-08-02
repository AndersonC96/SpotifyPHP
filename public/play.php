<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/SpotifyAPI.php';
    require '../src/config.php';
    session_start();
    if(!isset($_SESSION['access_token'])){
        echo json_encode(['success' => false]);
        exit();
    }
    $accessToken = $_SESSION['access_token'];
    $spotify = new SpotifyAPI($accessToken);
    $data = json_decode(file_get_contents('php://input'), true);
    $trackUri = $data['uri'];
    $response = $spotify->playTrack($trackUri);
    if($response){
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['success' => false]);
    }
?>