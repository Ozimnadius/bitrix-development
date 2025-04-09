<?php
$root = __DIR__; // можешь заменить на другой путь
$htaccessFiles = [];
$deleted = [];
$failed = [];

$iterator = new RecursiveIteratorIterator(
new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $file) {
if (
$file->isFile() &&
$file->getFilename() === '.htaccess' &&
realpath($file->getPath()) !== realpath($root)
) {
$path = $file->getPathname();
$htaccessFiles[] = $path;

// Пытаемся удалить файл
if (@unlink($path)) {
$deleted[] = $path;
} else {
$failed[] = $path;
}
}
}

// Выводим результат
echo "Найдено .htaccess файлов: " . count($htaccessFiles) . PHP_EOL . "<br/>";
echo "Удалено: " . count($deleted) . PHP_EOL. "<br/>";
echo "Не удалось удалить: " . count($failed) . PHP_EOL. "<br/>";

if (!empty($deleted)) {
echo "\nУдалённые файлы:\n";
echo json_encode($deleted, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
}

if (!empty($failed)) {
echo "\nФайлы, которые не удалось удалить:\n";
echo json_encode($failed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
}