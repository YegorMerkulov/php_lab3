<?php
require 'config.php';
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']); // Очищаем ошибку после показа
?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Авторизация</h2>
        
        <?php if ($error): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form action="login_handler.php" method="post">
            <div class="form-group">
                <input type="text" name="login" placeholder="Имя пользователя" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Пароль" required>
            </div>

            <button type="submit" class="button">Войти</button>
        </form>
        
        <div class="links">
            Нет аккаунта? <a href="register.php" class="link">Зарегистрироваться</a>
        </div>
    </div>
</body>
</html>