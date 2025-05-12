<?php
header('Content-Type: application/json');

// Файлы для хранения данных
$likesFile = 'likes.json';

// Инициализация файла, если он не существует
if (!file_exists($likesFile)) {
    file_put_contents($likesFile, '{}');
}

$messageId = $_POST['message_id'] ?? '';
$user = $_POST['user'] ?? '';

if ($messageId && $user) {
    $likesData = json_decode(file_get_contents($likesFile), true);
    
    // Инициализируем массив для сообщения, если его нет
    if (!isset($likesData[$messageId])) {
        $likesData[$messageId] = [];
    }
    
    // Проверяем, не лайкал ли уже пользователь это сообщение
    $userIndex = array_search($user, $likesData[$messageId]);
    
    if ($userIndex === false) {
        // Добавляем лайк
        $likesData[$messageId][] = $user;
    } else {
        // Удаляем лайк (дизлайк)
        array_splice($likesData[$messageId], $userIndex, 1);
    }
    
    file_put_contents($likesFile, json_encode($likesData));
    
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Недостаточно данных']);
}
?>