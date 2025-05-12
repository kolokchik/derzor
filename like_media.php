<?php
header('Content-Type: application/json');

$mediaLikesFile = 'media_likes.json';

// Получаем данные из запроса
$mediaId = $_POST['media_id'] ?? '';
$user = $_POST['user'] ?? '';

if (!$mediaId || !$user) {
    echo json_encode(['success' => false, 'error' => 'Недостаточно данных']);
    exit;
}

// Инициализация файла, если его нет
if (!file_exists($mediaLikesFile)) {
    file_put_contents($mediaLikesFile, '{}');
}

// Читаем текущие лайки
$mediaLikes = json_decode(file_get_contents($mediaLikesFile), true);

// Инициализируем массив для медиа, если его нет
if (!isset($mediaLikes[$mediaId])) {
    $mediaLikes[$mediaId] = [];
}

// Проверяем, не лайкал ли уже пользователь это медиа
$userIndex = array_search($user, $mediaLikes[$mediaId]);

if ($userIndex === false) {
    // Добавляем лайк
    $mediaLikes[$mediaId][] = $user;
} else {
    // Удаляем лайк
    array_splice($mediaLikes[$mediaId], $userIndex, 1);
}

// Сохраняем обновлённые лайки
file_put_contents($mediaLikesFile, json_encode($mediaLikes));

// Возвращаем успешный результат
echo json_encode([
    'success' => true,
    'count' => count($mediaLikes[$mediaId] ?? [])
]);
?>