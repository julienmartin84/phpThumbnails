<?php

include('functions.php');

//settings
$imagesFolder = 'images';
$thumbsFolder = 'thumbnails';
$keepAspectRatio = true; //if true, $thumbnailsHeight will be ignored
$thumbnailsWidth = 320;
$thumbnailsHeight = 240;
$sequentialRenaming = false;
$addThumbToName = true;

printSettings($keepAspectRatio, $thumbnailsWidth, $thumbnailsHeight, $sequentialRenaming, $addThumbToName);

$files = scandir($imagesFolder);
$thumbNumber = 1;
if (!file_exists('thumbnails')) {
    mkdir('thumbnails', 0777, true);
}

foreach($files as $file) {
    $file_parts = pathinfo($file);
    $extension = $file_parts['extension'];
    if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
        $imageBaseName = $file_parts['basename'];
        createThumbnail($imagesFolder, $thumbsFolder, $imageBaseName, $keepAspectRatio, $thumbnailsWidth, $thumbnailsHeight, $thumbNumber, $sequentialRenaming, $addThumbToName);
        $thumbNumber++;
    }
}

?>