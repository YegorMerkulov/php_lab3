<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['login'] ?? '');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $bg_color = $_POST['bg_color'] ?? '#ffffff';
    $text_color = $_POST['text_color'] ?? '#000000';

    // Сохраняем введенные данные для повторного показа
    $_SESSION['old_register_data'] = [
        'username' => $username,
        'bg_color' => $bg_color,
        'text_color' => $text_color
    ];

    // Валидация данных
    $error = null;
    
    if (empty($username) || empty($password)) {
        $error = "Все обязательные поля должны быть заполнены!";
    } elseif (!preg_match('/^#[a-f0-9]{6}$/i', $bg_color) || !preg_match('/^#[a-f0-9]{6}$/i', $text_color)) {
        $error = "Некорректный формат цвета!";
    } else {
        // Проверка существующего пользователя
        $stmt = $pdo->prepare("SELECT `id` FROM `auth_lab3` WHERE `login` = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Пользователь с таким именем уже существует!";
        }
    }

    if ($error) {
        $_SESSION['register_error'] = $error;
        header("Location: register.php");
        exit;
    }

    try {
        // Регистрация пользователя
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $pdo->beginTransaction();
        
        // Правильный запрос для таблицы с полями: login, password, bg_color, text_color
        $stmt = $pdo->prepare("INSERT INTO `auth_lab3`(`login`, `password`, `bg_color`, `text_color`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $bg_color, $text_color]);

        $pdo->commit();
        
        // Очистка временных данных
        unset($_SESSION['old_register_data']);
        
        header("Location: login.php");
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['register_error'] = "Ошибка регистрации: " . $e->getMessage();
        header("Location: register.php");
    }
}