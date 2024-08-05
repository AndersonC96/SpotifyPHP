# SpotifyPHP

SpotifyPHP é uma aplicação web desenvolvida em PHP que utiliza a API do Spotify para fornecer funcionalidades como exibição de músicas recentemente tocadas, playlists do usuário, artistas seguidos, episódios de podcasts recentes e muito mais.

## Funcionalidades

- **Login usando a conta do Spotify**
- **Exibir músicas recentemente tocadas**
- **Exibir playlists do usuário**
- **Exibir artistas seguidos pelo usuário**
- **Exibir episódios de podcasts recentes**
- **Player de música integrado com controles de reprodução**

## Requisitos

- PHP >= 7.4
- Composer
- Conta no Spotify Developer e credenciais da API
- XAMPP (ou qualquer outro servidor local)

## Instalação

1. Clone o repositório para o seu ambiente local:
    ```sh
    git clone https://github.com/seu-usuario/SpotifyPHP.git
    ```

2. Navegue até o diretório do projeto:
    ```sh
    cd SpotifyPHP
    ```

3. Instale as dependências do Composer:
    ```sh
    composer install
    ```

4. Configure suas credenciais da API do Spotify no arquivo `src/config.php`:
    ```php
    define('CLIENT_ID', 'seu-client-id');
    define('CLIENT_SECRET', 'seu-client-secret');
    define('REDIRECT_URI', 'http://localhost/SpotifyPHP/callback.php');
    ```

5. Inicie o servidor local (usando XAMPP ou outro servidor local):
    ```sh
    php -S localhost:8000 -t public
    ```

6. Acesse a aplicação em [http://localhost:8000](http://localhost:8000).

## Estrutura do Projeto

```plaintext
SpotifyPHP/
├── public/
│   ├── callback.php
│   ├── control.php
│   ├── index.php
│   ├── dashboard.php
│   ├── playlists.php
│   ├── followed_artists.php
│   ├── logout.php
│   ├── podcasts.php
│   ├── playlists.php
│   ├── recently_played.php
│   ├── navbar.php
│   ├── player.php
│   ├── search.php
├── src/
│   ├── SpotifyAuth.php
│   ├── SpotifyAPI.php
│   ├── config.php
├── vendor/
├── composer.json
└── README.md
```

## Uso
1. Acesse a página inicial e clique no botão de login para autorizar a aplicação a acessar sua conta do Spotify.
2. Navegue pelas diferentes páginas usando a navbar para visualizar suas playlists, músicas recentemente tocadas, artistas seguidos e episódios de podcasts recentes.
3. Use o player de música integrado para reproduzir prévias das músicas.