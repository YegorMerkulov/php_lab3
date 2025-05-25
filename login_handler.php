<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Все поля обязательны для заполнения!";
        header("Location: login.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM `auth_lab3` WHERE `login` = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['settings'] = [
            'background_color' => $user['bg_color'],
            'text_color' => $user['text_color']
        ];

        $cookie_time = time() + 60*60*24*30;
        setcookie('background_color', $user['bg_color'], $cookie_time, '/', '', false, true);
        setcookie('text_color', $user['text_color'], $cookie_time, '/', '', false, true);
        
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Неверное имя пользователя или пароль!";
        header("Location: login.php");
        exit;
    }
}