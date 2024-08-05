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
        <div class="container mx-auto px-4 py-8">
            <div class="card mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Your Playlists</h2>
                <?php if (isset($playlists['items']) && is_array($playlists['items'])): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($playlists['items'] as $playlist): ?>
                    <div class="playlist bg-gray-900 p-4 rounded-lg shadow-md flex flex-col items-center">
                        <?php if (isset($playlist['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($playlist['images'][0]['url']) ?>" alt="Playlist Image" class="w-full h-48 object-cover rounded-lg">
                        <?php endif; ?>
                        <div class="mt-4 text-center">
                            <p class="text-lg font-bold"><?= htmlspecialchars($playlist['name']) ?></p>
                        </div>
                        <a href="<?= htmlspecialchars($playlist['external_urls']['spotify']) ?>" target="_blank" class="mt-4 bg-cyan-500 text-white p-2 rounded-full flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.5 4.5M9 4.5h10.5M15 14.5l4.5 4.5M6 18h2.25m0 0A2.25 2.25 0 0110.5 20.25H6m2.25 0A2.25 2.25 0 016 18.75v-1.5m0-3.75h10.5M6 10.5V6m0 0A2.25 2.25 0 014.75 4.5H6M6 6v4.5" />
                            </svg>
                            View
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p>No playlists found.</p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>