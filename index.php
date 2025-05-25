<?php
require 'config.php';

// Если пользователь не авторизован, но есть cookies с настройками
if (!isset($_SESSION['id'])) {
    if (isset($_COOKIE['background_color']) || isset($_COOKIE['text_color'])) {
        $_SESSION['settings'] = [
            'background_color' => $_COOKIE['background_color'] ?? '#ffffff',
            'text_color' => $_COOKIE['text_color'] ?? '#000000'
        ];
    } else {
        header("Location: login.html");
        exit;
    }
}

// Применяем настройки
$style = '';
if (isset($_SESSION['settings'])) {
    // Применяем настройки (приоритет у сессии)
    $bg_color = $_SESSION['settings']['background_color'] ?? $_COOKIE['background_color'] ?? '#ffffff';
    $text_color = $_SESSION['settings']['text_color'] ?? $_COOKIE['text_color'] ?? '#000000';
    $style = "
        .navbar {
            background-color: $bg_color; 
            color: $text_color;
        }
        .nav-content { 
            color: $text_color;
        }
        .container {
            background-color: $bg_color; 
            color: $text_color;
        }
    ";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Главная</title>
    <link rel="stylesheet" href="style.css">
    <style><?= $style ?></style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <h1>Добро пожаловать!</h1>
            <div>
                <a href="profile.php" class="link">Настройки</a>
                <a href="logout.php" class="link">Выйти</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <h2>Ваш личный кабинет</h2>
    </div>
</body>
</html>