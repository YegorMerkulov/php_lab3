<?php
require 'config.php';
$error = $_SESSION['register_error'] ?? '';
$old_input = $_SESSION['old_register_data'] ?? [];
unset($_SESSION['register_error'], $_SESSION['old_register_data']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Регистрация</h2>
        <?php if ($error): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        <form action="register_handler.php" method="post">
            <div class="form-group">
                <input type="text" name="login" 
                       placeholder="Имя пользователя" 
                       value="<?= htmlspecialchars($old_input['login'] ?? '') ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" 
                       placeholder="Пароль" 
                       required>
            </div>

            <div class="form-group">
                <div class="color-preview">
                    <input type="color" name="bg_color" 
                           value="<?= htmlspecialchars($old_input['bg_color'] ?? '#ffffff') ?>">
                    <div class="color-box" 
                         style="background-color: <?= htmlspecialchars($old_input['bg_color'] ?? '#ffffff') ?>"></div>
                    <span>Цвет фона</span>
                </div>
            </div>

            <div class="form-group">
                <div class="color-preview">
                    <input type="color" name="text_color" 
                           value="<?= htmlspecialchars($old_input['text_color'] ?? '#000000') ?>">
                    <div class="color-box" 
                         style="background-color: <?= htmlspecialchars($old_input['text_color'] ?? '#000000') ?>"></div>
                    <span>Цвет текста</span>
                </div>
            </div>

            <button type="submit" class="button">Зарегистрироваться</button>
        </form>
        
        <div class="links">
            Уже есть аккаунт? <a href="login.php" class="link">Войти</a>
        </div>
    </div>

    <script>
        // Обновление превью цветов в реальном времени
        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('input', function() {
                this.closest('.color-preview').querySelector('.color-box').style.backgroundColor = this.value;
            });
        });
    </script>
</body>
</html>