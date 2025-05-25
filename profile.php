<?php
require 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bg_color = $_POST['bg_color'];
    $text_color = $_POST['text_color'];

    // Обновляем настройки в БД
    $stmt = $pdo->prepare("UPDATE `auth_lab3` SET `bg_color`=?, `text_color`=? WHERE `id`=?");
    $stmt->execute([$bg_color, $text_color, $_SESSION['id']]);

    // Обновляем сессию
    $_SESSION['settings']['background_color'] = $bg_color;
    $_SESSION['settings']['text_color'] = $text_color;
    
     // Обновляем cookies
    $cookie_time = time() + 60*60*24*30;
    setcookie('background_color', $bg_color, $cookie_time, '/', '', false, true);
    setcookie('text_color', $text_color, $cookie_time, '/', '', false, true);

    header("Location: index.php");
}

// Получаем текущие настройки (приоритет у сессии)
$bg_color = $_SESSION['settings']['background_color'] ?? $_COOKIE['background_color'] ?? '#ffffff';
$text_color = $_SESSION['settings']['text_color'] ?? $_COOKIE['text_color'] ?? '#000000';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Настройки</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Настройки профиля</h2>
        <form method="POST">
             <div class="form-group">
                <div class="color-preview">
                    <input type="color" name="bg_color" value="#ffffff">
                    <div class="color-box" style="background-color: #ffffff"></div>
                    <span>Цвет фона</span>
                </div>
            </div>

            <div class="form-group">
                <div class="color-preview">
                    <input type="color" name="text_color" value="#000000">
                    <div class="color-box" style="background-color: #000000"></div>
                    <span>Цвет текста</span>
                </div>
            </div>
            <button type="submit" class="button">Сохранить</button>
        </form>
        <div class="links">
            <a href="index.php">На главную</a>
        </div>
    </div>
</body>
</html>