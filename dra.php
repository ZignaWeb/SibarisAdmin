<?php
$img="http://www.justiciacordoba.gob.ar/justiciacordoba/paginas/CaptchaImage.axd?guid=1af2e516-108e-4cea-9c02-fa8bdbba9523";
$size=getimagesize($img);
$w=$size[0];
$h=$size[1];
$ima = imagecreatefromjpeg($img);
for ($y=0; $y<$h; $y++) {
	for ($x=0; $x<$w; $x++) {
		$rgb = dechex(imagecolorat($ima, $x, $y));
		if ($rgb=="000000") {
			$colors[$y][$x]=$rgb;	
		}
	}
}
$imgNew = imagecreatetruecolor($w,$h);
header('Content-Type: image/png');
foreach ($colors[$y] as $key => $val) {
	imagesetpixel($gd, round($x),round($y), $red);
}
imagepng($imgNew);
?>