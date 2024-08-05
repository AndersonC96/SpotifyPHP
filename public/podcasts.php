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
    $recentlyPlayed = $spotify->getRecentlyPlayedTracks();
    $recentlyPlayedEpisodes = array_filter($recentlyPlayed['items'], function ($item){
        return $item['track']['type'] === 'episode';
    });
    $recentlyPlayedEpisodeIds = array_map(function ($item){
        return $item['track']['id'];
    }, $recentlyPlayedEpisodes);
?>
        <style>
        .listen-button{
                background: #1db954;
                color: white;
                padding: 10px 20px;
                border-radius: 25px;
                text-decoration: none;
                transition: background-color 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
            }
            .listen-button:hover{
                background: #1ed760;
            }
            .listen-button svg{
                margin-right: 8px;
            }
        </style>
        <?php include 'navbar.php'; ?>
        <div class="container mx-auto px-4 py-8 mt-16">
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Recent Podcast Episodes</h2>
                <?php if (isset($podcasts['items']) && is_array($podcasts['items'])): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php foreach ($podcasts['items'] as $show): ?>
                    <?php
                        $episodes = $spotify->callAPI("https://api.spotify.com/v1/shows/{$show['show']['id']}/episodes?limit=1");
                        if(isset($episodes['items'][0])){
                            $episode = $episodes['items'][0];
                            if(in_array($episode['id'], $recentlyPlayedEpisodeIds)){
                                continue;
                            }
                        }else{
                            continue;
                        }
                    ?>
                    <div class="episode bg-gray-900 p-4 rounded-lg shadow-md flex flex-col h-full">
                        <div class="flex items-center mb-4">
                            <?php if (isset($episode['images'][0]['url'])): ?>
                            <img src="<?= htmlspecialchars($episode['images'][0]['url']) ?>" alt="Episode Image" class="w-24 h-24 object-cover rounded-lg">
                            <?php endif; ?>
                            <div class="ml-4 flex flex-col">
                                <p class="font-bold text-lg"><?= htmlspecialchars($episode['name'] ?? 'No name') ?></p>
                                <p class="text-sm text-gray-400"><?= htmlspecialchars(date('d/m/Y', strtotime($episode['release_date'] ?? ''))) ?></p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 mb-4 flex-grow"><?= htmlspecialchars($episode['description'] ?? 'No description') ?></p>
                        <a href="<?= htmlspecialchars($episode['external_urls']['spotify'] ?? '#') ?>" target="_blank" class="mt-auto listen-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.5 4.5M9 4.5h10.5M15 14.5l4.5 4.5M6 18h2.25m0 0A2.25 2.25 0 0110.5 20.25H6m2.25 0A2.25 2.25 0 016 18.75v-1.5m0-3.75h10.5M6 10.5V6m0 0A2.25 2.25 0 014.75 4.5H6M6 6v4.5" />
                            </svg>
                            Listen
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p>No recent episodes found.</p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>