<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
                padding: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 10;
            }
            .navbar a, .navbar button{
                margin: 0 10px;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                color: white;
                background-color: #4a5568;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .navbar a:hover, .navbar button:hover{
                background-color: #5b6a79;
            }
            .search-bar{
                display: flex;
                align-items: center;
            }
            .search-input{
                padding: 5px 10px;
                border-radius: 5px;
                border: none;
                margin-right: 10px;
            }
            .container{
                margin-top: 80px;
                width: 100%;
                max-width: 1200px;
            }
            .card{
                background: #2d3748;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <div class="links">
                <a href="dashboard.php">Home</a>
                <a href="playlists.php">Playlists</a>
                <a href="recently_played.php">Recently Played</a>
                <a href="followed_artists.php">Followed Artists</a>
                <a href="podcasts.php">Podcasts</a>
            </div>
            <form class="search-bar" method="GET" action="search.php">
                <input type="text" name="query" class="search-input" placeholder="Search for music...">
                <button type="submit" class="navbar-button">Search</button>
            </form>
            <a href="logout.php">Clear Session</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="container">