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
            <div class="card">
                <?php if (isset($userData['images']) && !empty($userData['images'])): ?>
                <img src="<?= htmlspecialchars($userData['images'][0]['url']) ?>" alt="Profile Picture" class="profile-picture" width="100">
                <?php endif; ?>
                <h1 class="text-3xl font-bold mb-4">Welcome, <?= isset($userData['display_name']) ? htmlspecialchars($userData['display_name']) : 'User' ?></h1>
                <p class="mb-2"><strong>Email:</strong> <?= isset($userData['email']) ? htmlspecialchars($userData['email']) : 'Not provided' ?></p>
                <p class="mb-4"><strong>Country:</strong> <?= isset($userData['country']) ? htmlspecialchars($userData['country']) : 'Not provided' ?></p>
            </div>
            <?php if ($currentPlaying && isset($currentPlaying['item'])): ?>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Now Playing</h2>
                <div class="flex items-center">
                    <?php if (isset($currentPlaying['item']['album']['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($currentPlaying['item']['album']['images'][0]['url']) ?>" alt="Album Image" width="50">
                    <?php endif; ?>
                    <div class="ml-4">
                        <p class="font-bold"><?= htmlspecialchars($currentPlaying['item']['name']) ?> by <?= htmlspecialchars($currentPlaying['item']['artists'][0]['name']) ?></p>
                    </div>
                </div>
                <audio controls autoplay>
                    <source src="<?= htmlspecialchars($currentPlaying['item']['preview_url']) ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>