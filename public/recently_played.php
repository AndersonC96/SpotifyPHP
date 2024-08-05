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
        <div class="container mx-auto px-4 py-8">
            <div class="card mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Recently Played Tracks</h2>
                <?php if (isset($recentTracks['items']) && is_array($recentTracks['items'])): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($recentTracks['items'] as $item): ?>
                    <div class="track bg-gray-900 p-4 rounded-lg shadow-md flex flex-col items-center">
                        <?php if (isset($item['track']['album']['images'][0]['url'])): ?>
                            <img src="<?= htmlspecialchars($item['track']['album']['images'][0]['url']) ?>" alt="Track Image" class="w-full h-48 object-cover rounded-lg">
                        <?php endif; ?>
                        <div class="mt-4 text-center">
                            <p class="text-lg font-bold"><?= htmlspecialchars($item['track']['name']) ?></p>
                            <p class="text-gray-400"><?= htmlspecialchars($item['track']['artists'][0]['name']) ?></p>
                        </div>
                        <button class="mt-4 bg-cyan-500 text-white p-2 rounded-full play-button" data-uri="<?= htmlspecialchars($item['track']['preview_url']) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.44 3.694A1 1 0 017 14.06V9.94a1 1 0 011.312-.946l6.44 3.694a1 1 0 010 1.686z" />
                            </svg>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p>No recently played tracks found.</p>
                <?php endif; ?>
            </div>
        </div>
        <audio id="audio-player" class="hidden"></audio>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const audioPlayer = document.getElementById('audio-player');
                document.querySelectorAll('.play-button').forEach(button => {
                    button.addEventListener('click', function (){
                        const trackUri = this.getAttribute('data-uri');
                        if(trackUri){
                            audioPlayer.src = trackUri;
                            audioPlayer.play();
                        }
                    });
                });
            });
        </script>
    </body>
</html>