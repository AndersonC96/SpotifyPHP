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
    $userData = $spotify->getUserData();
    $currentPlaying = $spotify->getCurrentlyPlaying();
    $topTracks = $spotify->callAPI("https://api.spotify.com/v1/me/top/tracks?limit=10");
    $topArtists = $spotify->callAPI("https://api.spotify.com/v1/me/top/artists?limit=10");
?>
        <?php include 'navbar.php'; ?>
        <div class="container mx-auto px-4 py-8">
            <div class="card mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                <h1 class="text-4xl font-bold mb-2">Bem-vindo, <?= isset($userData['display_name']) ? htmlspecialchars($userData['display_name']) : 'Usuário' ?></h1>
            </div>
            <?php if ($currentPlaying && isset($currentPlaying['item'])): ?>
            <div class="card mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                <div class="flex items-center space-x-4">
                    <?php if (isset($currentPlaying['item']['album']['images'][0]['url'])): ?>
                    <img src="<?= htmlspecialchars($currentPlaying['item']['album']['images'][0]['url']) ?>" alt="Album Image" class="w-24 h-24 rounded-lg">
                    <?php endif; ?>
                    <div>
                        <p class="text-cyan-500 text-sm"><?= htmlspecialchars($currentPlaying['item']['type'] === 'episode' ? 'Episode' : 'Track') ?></p>
                        <h2 class="text-2xl font-semibold"><?= htmlspecialchars($currentPlaying['item']['name']) ?></h2>
                        <p class="text-xl"><?= htmlspecialchars($currentPlaying['item']['artists'][0]['name']) ?></p>
                    </div>
                </div>
                <?php if (isset($currentPlaying['item']['preview_url'])): ?>
                <div class="mt-4">
                    <audio id="audio-player" src="<?= htmlspecialchars($currentPlaying['item']['preview_url']) ?>" class="w-full"></audio>
                    <div class="relative mt-4">
                        <div class="bg-gray-700 rounded-full overflow-hidden">
                            <div id="progress-bar" class="bg-cyan-500 h-2" role="progressbar" aria-label="music progress"></div>
                        </div>
                        <div class="ring-cyan-500 ring-2 absolute left-1/2 top-1/2 w-4 h-4 -mt-2 -ml-2 flex items-center justify-center bg-white rounded-full shadow">
                            <div class="w-1.5 h-1.5 bg-cyan-500 rounded-full ring-1 ring-inset ring-gray-900/5"></div>
                        </div>
                    </div>
                    <div class="flex justify-between text-sm leading-6 font-medium tabular-nums mt-2">
                        <div class="text-cyan-500" id="current-time">0:00</div>
                        <div class="text-gray-400" id="duration">0:00</div>
                    </div>
                </div>
                <div class="bg-gray-800 text-gray-200 rounded-b-xl flex items-center mt-4">
                    <div class="flex-auto flex items-center justify-evenly">
                        <button type="button" aria-label="Add to favorites">
                            <svg width="24" height="24">
                                <path d="M7 6.931C7 5.865 7.853 5 8.905 5h6.19C16.147 5 17 5.865 17 6.931V19l-5-4-5 4V6.931Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="hidden sm:block lg:hidden xl:block" aria-label="Previous" id="prev-button">
                            <svg width="24" height="24" fill="none">
                                <path d="m10 12 8-6v12l-8-6Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 6v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" aria-label="Rewind 10 seconds" id="rewind-button">
                            <svg width="24" height="24" fill="none">
                                <path d="M6.492 16.95c2.861 2.733 7.5 2.733 10.362 0 2.861-2.734 2.861-7.166 0-9.9-2.862-2.733-7.501-2.733-10.362 0A7.096 7.096 0 0 0 5.5 8.226" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 5v3.111c0 .491.398.889.889.889H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <button type="button" class="bg-white text-gray-900 dark:bg-gray-100 dark:text-gray-700 flex-none -my-2 mx-auto w-20 h-20 rounded-full ring-1 ring-gray-900/5 shadow-md flex items-center justify-center" aria-label="Play/Pause" id="play-pause-button">
                        <svg width="30" height="32" fill="currentColor" id="play-icon">
                            <polygon points="10,8 24,16 10,24"></polygon>
                        </svg>
                        <svg width="30" height="32" fill="currentColor" id="pause-icon" class="hidden">
                            <rect x="6" y="4" width="4" height="24" rx="2" />
                            <rect x="20" y="4" width="4" height="24" rx="2" />
                        </svg>
                    </button>
                    <div class="flex-auto flex items-center justify-evenly">
                        <button type="button" aria-label="Skip 10 seconds" id="skip-button">
                            <svg width="24" height="24" fill="none">
                                <path d="M17.509 16.95c-2.862 2.733-7.501 2.733-10.363 0-2.861-2.734-2.861-7.166 0-9.9 2.862-2.733 7.501-2.733 10.363 0 .38.365.711.759.991 1.176" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M19 5v3.111c0 .491-.398.889-.889.889H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="hidden sm:block lg:hidden xl:block" aria-label="Next" id="next-button">
                            <svg width="24" height="24" fill="none">
                                <path d="M14 12 6 6v12l8-6Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M18 6v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="rounded-lg text-xs leading-6 font-semibold px-2 ring-2 ring-inset ring-gray-500 text-gray-500 dark:text-gray-100 dark:ring-0 dark:bg-gray-500" id="speed-button">1x</button>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-red-500">No preview available for this track.</p>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="card mb-6 p-4 bg-gray-800 rounded-lg shadow-md">
                <p class="text-red-500">No track is currently playing.</p>
            </div>
            <?php endif; ?>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const audioPlayer = document.getElementById('audio-player');
                const progressBar = document.getElementById('progress-bar');
                const currentTime = document.getElementById('current-time');
                const duration = document.getElementById('duration');
                const playPauseButton = document.getElementById('play-pause-button');
                const playIcon = document.getElementById('play-icon');
                const pauseIcon = document.getElementById('pause-icon');
                const rewindButton = document.getElementById('rewind-button');
                const skipButton = document.getElementById('skip-button');
                const speedButton = document.getElementById('speed-button');
                if(audioPlayer && progressBar && currentTime && duration){
                        audioPlayer.addEventListener('loadedmetadata', () => {
                        duration.textContent = formatTime(audioPlayer.duration);
                    });
                    audioPlayer.addEventListener('timeupdate', () => {
                        const current = audioPlayer.currentTime;
                        const total = audioPlayer.duration;
                        progressBar.style.width = `${(current / total) * 100}%`;
                        currentTime.textContent = formatTime(current);
                    });
                    playPauseButton.addEventListener('click', () => {
                        if(audioPlayer.paused){
                            audioPlayer.play();
                            playIcon.classList.add('hidden');
                            pauseIcon.classList.remove('hidden');
                        }else{
                            audioPlayer.pause();
                            playIcon.classList.remove('hidden');
                            pauseIcon.classList.add('hidden');
                        }
                    });
                    rewindButton.addEventListener('click', () => {
                        audioPlayer.currentTime = Math.max(audioPlayer.currentTime - 10, 0);
                    });
                    skipButton.addEventListener('click', () => {
                        audioPlayer.currentTime = Math.min(audioPlayer.currentTime + 10, audioPlayer.duration);
                    });
                    speedButton.addEventListener('click', () => {
                        if(audioPlayer.playbackRate === 1){
                            audioPlayer.playbackRate = 1.5;
                            speedButton.textContent = '1.5x';
                        }else if(audioPlayer.playbackRate === 1.5){
                            audioPlayer.playbackRate = 2;
                            speedButton.textContent = '2x';
                        }else{
                            audioPlayer.playbackRate = 1;
                            speedButton.textContent = '1x';
                        }
                    });
                    const formatTime = (seconds) => {
                        const mins = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60);
                        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
                    };
                }
            });
        </script>
    </body>
</html>