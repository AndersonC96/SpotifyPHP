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
    $recentTracks = $spotify->getRecentlyPlayedTracks();
?>
            <?php include 'navbar.php'; ?>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Recently Played Tracks</h2>
                <?php if (isset($recentTracks['items']) && is_array($recentTracks['items'])): ?>
                <?php foreach ($recentTracks['items'] as $item): ?>
                <div class="track">
                    <div class="flex items-center">
                        <?php if (isset($item['track']['album']['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($item['track']['album']['images'][0]['url']) ?>" alt="Track Image" width="50">
                        <?php endif; ?>
                        <p class="ml-4"><?= htmlspecialchars($item['track']['name']) ?> by <?= htmlspecialchars($item['track']['artists'][0]['name']) ?></p>
                    </div>
                    <a href="#" class="play-button" onclick="playTrack('<?= htmlspecialchars($item['track']['uri']) ?>')">Play</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No recently played tracks found.</p>
                <?php endif; ?>
            </div>
        </div>
        <script>
            function playTrack(trackUri) {
                fetch('play.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ uri: trackUri })
                }).then(response => response.json())
                .then(data => {
                    if(data.success){
                        alert('Track is playing!');
                    }else{
                        alert('Failed to play track.');
                    }
                });
            }
        </script>
    </body>
</html>