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
        </div>
    </body>
</html>