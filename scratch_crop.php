<?php
$img = imagecreatefrompng('C:/Users/user/.gemini/antigravity/brain/62423831-efbf-4ca7-99fe-3575db69fa0e/.user_uploaded/media_1789083863156.png');
$w = imagesx($img);
$h = imagesy($img);

// Crop bottom-left 150x150
$crop = imagecrop($img, ['x' => 0, 'y' => $h - 150, 'width' => 150, 'height' => 150]);
imagepng($crop, 'bottom_left_inspect.png');
echo "Cropped bottom left image: 150x150\n";
