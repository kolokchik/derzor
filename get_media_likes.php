<?php
header('Content-Type: application/json');

$mediaLikesFile = 'media_likes.json';

// Если файла нет - создаём пустой
if (!file_exists($mediaLikesFile)) {
    file_put_contents($mediaLikesFile, '{}');
}

// Читаем текущие лайки
$mediaLikes = json_decode(file_get_contents($mediaLikesFile), true);

// Для каждого медиа добавляем информацию о количестве лайков и пользователях
$result = [];
foreach ($mediaLikes as $mediaId => $users) {
    $result[$mediaId] = [
        'count' => count($users),
        'users' => $users
    ];
}

echo json_encode($result);
?>