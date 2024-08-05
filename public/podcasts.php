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
    $podcasts = $spotify->getUserPodcasts();
?>
            <?php include 'navbar.php'; ?>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Recent Podcast Episodes</h2>
                <?php if (isset($podcasts['items']) && is_array($podcasts['items'])): ?>
                <?php foreach ($podcasts['items'] as $show): ?>
                <?php
                    $episodes = $spotify->callAPI("https://api.spotify.com/v1/shows/{$show['show']['id']}/episodes?limit=1");
                    if(isset($episodes['items'][0])){
                        $episode = $episodes['items'][0];
                    }else{
                        continue;
                    }
                ?>
                <div class="episode">
                    <div class="flex items-center">
                        <?php if (isset($episode['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($episode['images'][0]['url']) ?>" alt="Episode Image" width="50">
                        <?php endif; ?>
                        <div class="ml-4">
                            <p class="font-bold"><?= htmlspecialchars($episode['name'] ?? 'No name') ?></p>
                            <p class="text-sm"><?= htmlspecialchars($episode['description'] ?? 'No description') ?></p>
                            <p class="text-sm text-gray-400"><?= htmlspecialchars(date('d/m/Y', strtotime($episode['release_date'] ?? ''))) ?></p>
                        </div>
                    </div>
                    <a href="<?= htmlspecialchars($episode['external_urls']['spotify'] ?? '#') ?>" target="_blank" class="view-button">Listen</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No recent episodes found.</p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>