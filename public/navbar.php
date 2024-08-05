<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnH/PRZwI2j7U7G5n6bzN3t6FP6b4TAO5kdf7vvbmevR2Y7XQmXVTX1FAKNx4LSk7JpSZZMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            body{
                font-family: 'Montserrat', sans-serif;
                background: #1f2937;
                color: white;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 20px;
            }
            .navbar{
                width: 100%;
                background: #2d3748;
                padding: 10px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 10;
                border-bottom: 1px solid #4a5568;
            }
            .navbar a{
                margin: 0 10px;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                color: white;
                background-color: transparent;
                transition: background-color 0.3s;
            }
            .navbar a:hover{
                background-color: #5b6a79;
            }
            .search-bar{
                display: flex;
                align-items: center;
                background-color: #4a5568;
                border-radius: 5px;
                padding: 5px;
            }
            .search-input{
                padding: 5px 10px;
                border-radius: 5px;
                border: none;
                margin-right: 10px;
                background-color: transparent;
                color: white;
            }
            .search-input::placeholder{
                color: #a0aec0;
            }
            .profile-picture{
                border-radius: 9999px;
                height: 32px;
                width: 32px;
                cursor: pointer;
            }
            .dropdown{
                position: relative;
                display: inline-block;
            }
            .dropdown-content{
                display: none;
                position: absolute;
                right: 0;
                background-color: #2d3748;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }
            .dropdown-content a{
                color: white;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }
            .dropdown-content a:hover{
                background-color: #5b6a79;
            }
            .dropdown:hover .dropdown-content{
                display: block;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <div class="flex items-center space-x-4">
                <a href="dashboard.php" class="text-sm font-medium">Home</a>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="text-sm font-medium">Music</a>
                    <div class="dropdown-content">
                        <a href="recently_played.php" class="text-sm font-medium">Recently Played</a>
                        <a href="playlists.php" class="text-sm font-medium">Playlists</a>
                    </div>
                </div>
                <a href="followed_artists.php" class="text-sm font-medium">Followed Artists</a>
                <a href="podcasts.php" class="text-sm font-medium">Podcasts</a>
            </div>
            <form class="search-bar" method="GET" action="search.php">
                <input type="text" name="query" class="search-input" placeholder="Search">
            </form>
            <div class="flex items-center space-x-4">
                <div class="dropdown">
                    <?php if (isset($userData['images']) && !empty($userData['images'])): ?>
                    <img src="<?= htmlspecialchars($userData['images'][0]['url']) ?>" alt="Profile Picture" class="h-8 w-8 rounded-full">
                    <?php endif; ?>
                    <div class="dropdown-content">
                        <a href="logout.php" class="text-sm font-medium"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-4 py-8">