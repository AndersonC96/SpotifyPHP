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
?>
        <?php include 'navbar.php'; ?>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
                <?php if (isset($userData['images']) && !empty($userData['images'])): ?>
                <img src="<?= htmlspecialchars($userData['images'][0]['url']) ?>" alt="Profile Picture" class="profile-picture rounded-full w-24 h-24 mb-4">
                <?php endif; ?>
                <h1 class="text-4xl font-bold mb-2">Welcome, <?= isset($userData['display_name']) ? htmlspecialchars($userData['display_name']) : 'User' ?></h1>
                <p class="text-xl mb-2"><strong>Email:</strong> <?= isset($userData['email']) ? htmlspecialchars($userData['email']) : 'Not provided' ?></p>
                <p class="text-xl mb-2"><strong>Country:</strong> <?= isset($userData['country']) ? htmlspecialchars($userData['country']) : 'Not provided' ?></p>
            </div>
            <?php if ($currentPlaying && isset($currentPlaying['item'])): ?>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center space-x-4">
                    <?php if (isset($currentPlaying['item']['album']['images'][0]['url'])): ?>
                    <img src="<?= htmlspecialchars($currentPlaying['item']['album']['images'][0]['url']) ?>" alt="Album Image" width="88" height="88" class="flex-none rounded-lg bg-slate-100" loading="lazy" />
                    <?php endif; ?>
                    <div class="min-w-0 flex-auto space-y-1 font-semibold">
                        <p class="text-cyan-500 dark:text-cyan-400 text-sm leading-6">
                            <?= htmlspecialchars($currentPlaying['item']['type'] === 'episode' ? 'Episode' : 'Track') ?>
                        </p>
                        <h2 class="text-slate-500 dark:text-slate-400 text-sm leading-6 truncate">
                            <?= htmlspecialchars($currentPlaying['item']['name']) ?>
                        </h2>
                        <p class="text-slate-900 dark:text-slate-50 text-lg">
                            <?= htmlspecialchars($currentPlaying['item']['artists'][0]['name']) ?>
                        </p>
                    </div>
                </div>
                <?php if (isset($currentPlaying['item']['preview_url'])): ?>
                <div class="space-y-2">
                    <div class="relative">
                        <div class="bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div id="progress-bar" class="bg-cyan-500 dark:bg-cyan-400 h-2" role="progressbar" aria-label="music progress"></div>
                        </div>
                        <div class="ring-cyan-500 dark:ring-cyan-400 ring-2 absolute left-1/2 top-1/2 w-4 h-4 -mt-2 -ml-2 flex items-center justify-center bg-white rounded-full shadow">
                            <div class="w-1.5 h-1.5 bg-cyan-500 dark:bg-cyan-400 rounded-full ring-1 ring-inset ring-slate-900/5"></div>
                        </div>
                    </div>
                    <div class="flex justify-between text-sm leading-6 font-medium tabular-nums">
                        <div class="text-cyan-500 dark:text-slate-100" id="current-time">0:00</div>
                        <div class="text-slate-500 dark:text-slate-400" id="duration">0:00</div>
                    </div>
                </div>
                <div class="bg-slate-50 text-slate-500 dark:bg-slate-600 dark:text-slate-200 rounded-b-xl flex items-center">
                    <div class="flex-auto flex items-center justify-evenly">
                        <button type="button" aria-label="Add to favorites">
                            <svg width="24" height="24">
                                <path d="M7 6.931C7 5.865 7.853 5 8.905 5h6.19C16.147 5 17 5.865 17 6.931V19l-5-4-5 4V6.931Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="hidden sm:block lg:hidden xl:block" aria-label="Previous">
                            <svg width="24" height="24" fill="none">
                                <path d="m10 12 8-6v12l-8-6Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 6v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" aria-label="Rewind 10 seconds">
                            <svg width="24" height="24" fill="none">
                                <path d="M6.492 16.95c2.861 2.733 7.5 2.733 10.362 0 2.861-2.734 2.861-7.166 0-9.9-2.862-2.733-7.501-2.733-10.362 0A7.096 7.096 0 0 0 5.5 8.226" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 5v3.111c0 .491.398.889.889.889H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <button type="button" class="bg-white text-slate-900 dark:bg-slate-100 dark:text-slate-700 flex-none -my-2 mx-auto w-20 h-20 rounded-full ring-1 ring-slate-900/5 shadow-md flex items-center justify-center" aria-label="Pause">
                        <svg width="30" height="32" fill="currentColor">
                            <rect x="6" y="4" width="4" height="24" rx="2" />
                            <rect x="20" y="4" width="4" height="24" rx="2" />
                        </svg>
                    </button>
                    <div class="flex-auto flex items-center justify-evenly">
                        <button type="button" aria-label="Skip 10 seconds">
                            <svg width="24" height="24" fill="none">
                                <path d="M17.509 16.95c-2.862 2.733-7.501 2.733-10.363 0-2.861-2.734-2.861-7.166 0-9.9 2.862-2.733 7.501-2.733 10.363 0 .38.365.711.759.991 1.176" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M19 5v3.111c0 .491-.398.889-.889.889H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="hidden sm:block lg:hidden xl:block" aria-label="Next">
                            <svg width="24" height="24" fill="none">
                                <path d="M14 12 6 6v12l8-6Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M18 6v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="rounded-lg text-xs leading-6 font-semibold px-2 ring-2 ring-inset ring-slate-500 text-slate-500 dark:text-slate-100 dark:ring-0 dark:bg-slate-500">1x</button>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-red-500">No preview available for this track.</p>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <p class="text-red-500">No track is currently playing.</p>
            <?php endif; ?>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function (){
                const progressBar = document.getElementById('progress-bar');
                const currentTime = document.getElementById('current-time');
                const duration = document.getElementById('duration');
                if (progressBar && currentTime && duration){
                    const updateProgress = () => {
                        const audio = document.getElementById('audio-player');
                        if(audio){
                            const current = audio.currentTime;
                            const total = audio.duration;
                            progressBar.style.width = `${(current / total) * 100}%`;
                            currentTime.textContent = formatTime(current);
                            duration.textContent = formatTime(total);
                        }
                    };
                    const formatTime = (seconds) => {
                        const mins = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60);
                        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
                    };
                    setInterval(updateProgress, 1000);
                }
            });
        </script>
    </body>
</html>