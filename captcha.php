
<?php
session_start();
$number1 = rand(1, 9);
$number2 = rand(1, 9);
$_SESSION['captcha'] = $number1 + $number2;

header('Content-type: image/png');
$image = imagecreate(100, 40);
$bg = imagecolorallocate($image, 255, 255, 255);
$color = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 10, 10, "$number1 + $number2 = ?", $color);
imagepng($image);
imagedestroy($image);
?>
