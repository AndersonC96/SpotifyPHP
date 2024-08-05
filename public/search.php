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
    $query = $_GET['query'] ?? '';
    $results = [];
    if($query){
        $results = $spotify->search($query);
    }
?>
            <?php include 'navbar.php'; ?>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Search Results for "<?= htmlspecialchars($query) ?>"</h2>
                <?php if (!empty($results)): ?>
                <?php if (isset($results['tracks']['items']) && is_array($results['tracks']['items'])): ?>
                <h3 class="text-xl font-bold mb-2">Tracks</h3>
                <?php foreach ($results['tracks']['items'] as $track): ?>
                <div class="track">
                    <div class="flex items-center">
                        <?php if (isset($track['album']['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($track['album']['images'][0]['url']) ?>" alt="Track Image" width="50">
                        <?php endif; ?>
                        <div class="ml-4">
                            <p class="font-bold"><?= htmlspecialchars($track['name']) ?> by <?= htmlspecialchars($track['artists'][0]['name']) ?></p>
                        </div>
                    </div>
                    <a href="#" class="play-button" onclick="playTrack('<?= htmlspecialchars($track['uri']) ?>')">Play</a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <?php else: ?>
                <p>No results found.</p>
                <?php endif; ?>
            </div>
        </div>
        <script>
            function playTrack(trackUri){
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