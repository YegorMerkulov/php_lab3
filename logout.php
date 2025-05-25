<?php
require 'config.php';

// Уничтожаем сессию
session_destroy();

// Очищаем cookies
setcookie('background_color', '', time() - 3600, '/');
setcookie('text_color', '', time() - 3600, '/');

header("Location: login.php");
exit;
?>