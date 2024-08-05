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
    $followedArtists = $spotify->getFollowedArtists();
?>
            <?php include 'navbar.php'; ?>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Followed Artists</h2>
                <?php if (isset($followedArtists['artists']['items']) && is_array($followedArtists['artists']['items'])): ?>
                <?php foreach ($followedArtists['artists']['items'] as $artist): ?>
                <div class="artist">
                    <div class="flex items-center">
                        <?php if (isset($artist['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($artist['images'][0]['url']) ?>" alt="Artist Image" width="50">
                        <?php endif; ?>
                        <p class="ml-4"><?= htmlspecialchars($artist['name']) ?></p>
                    </div>
                    <a href="<?= htmlspecialchars($artist['external_urls']['spotify']) ?>" target="_blank" class="view-button">View</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No followed artists found.</p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>