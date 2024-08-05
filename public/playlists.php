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
    $playlists = $spotify->getUserPlaylists();
?>
            <?php include 'navbar.php'; ?>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Your Playlists</h2>
                <?php if (isset($playlists['items']) && is_array($playlists['items'])): ?>
                <?php foreach ($playlists['items'] as $playlist): ?>
                <div class="playlist">
                    <div class="flex items-center">
                        <?php if (isset($playlist['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($playlist['images'][0]['url']) ?>" alt="Playlist Image" width="50">
                        <?php endif; ?>
                        <p class="ml-4"><?= htmlspecialchars($playlist['name']) ?></p>
                    </div>
                    <a href="<?= htmlspecialchars($playlist['external_urls']['spotify']) ?>" target="_blank" class="view-button">View</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No playlists found.</p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>