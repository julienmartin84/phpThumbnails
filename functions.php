<?php

function createThumbnail($imageFolder, $thumbsFolder, $imageName, $keepAspectRatio, $thumbWidth, $thumbH, $thumbNumber, $seqRenaming, $addThumb) {
    $imagePath = $imageFolder . '/' . $imageName;
    $basename = pathinfo($imagePath)['filename'];
    $extension = pathinfo($imagePath)['extension'];
    $image = null;

    //source image
    switch ($extension) {
        case 'jpg':
            $image = imagecreatefromjpeg($imagePath);
            break;
        case 'png':
            $image = imagecreatefrompng($imagePath);
            break;
        case 'gif':
            $image = imagecreatefromgif($imagePath);
            break;
    }
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);
    echo $thumbNumber . ') Generating thumbnail for ' . $imageFolder . '/' . $imageName . ' (' . $imageWidth . 'x' . $imageHeight . ')<br />';

    //thumbnail image
    if ($keepAspectRatio) {
        $ratio = $imageWidth / $imageHeight;
        $thumbHeight = $thumbWidth / $ratio;
        $thumbHeight = (int)$thumbHeight;
    } else {
        $thumbHeight = $thumbH;
    }
    $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $imageWidth, $imageHeight);

    //defining thumbnail name based on user settings
    $thumbPath = $thumbsFolder . '/';
    if ($seqRenaming) {
        $thumbPath = $thumbPath . $thumbNumber;
    } else {
        $thumbPath = $thumbPath . $basename;
    }
    if ($addThumb) {
        $thumbPath = $thumbPath . '_thumb.' . $extension;
    } else {
        $thumbPath =  $thumbPath . '.' . $extension;
    }

    echo 'Saving to ' . $thumbPath . ' (' . $thumbWidth . 'x' . $thumbHeight . ')<br />';
    switch ($extension) {
        case 'jpg':
            imagejpeg($thumbnail, $thumbPath);
            break;
        case 'png':
            imagepng($thumbnail, $thumbPath);
            break;
        case 'gif':
            imagegif($thumbnail, $thumbPath);
            break;
    }
}

function printSettings($keepAspectRatio, $thumbnailsWidth, $thumbnailsHeight, $sequentialRenaming, $addThumbToName) {
    echo 'Settings<br />';
    echo '-----------<br />';
    echo 'Keep aspect ratio : ';
    if ($keepAspectRatio) {
        echo 'yes<br />';
        echo 'Thumbnails width : ' . $thumbnailsWidth . '<br />';
    } else {
        echo 'no<br />';
        echo 'Thumbnails width : ' . $thumbnailsWidth . '<br />';
        echo 'Thumbnails height : ' . $thumbnailsHeight . '<br />';
    }
    echo 'Sequential renaming : ';
    echo $sequentialRenaming ? 'yes' : 'no';
    echo '<br />';
    echo 'Add _thumb to thumbnails names : ';
    echo $addThumbToName ? 'yes' : 'no';
    echo '<br />';
    echo '<br />';
}

?>