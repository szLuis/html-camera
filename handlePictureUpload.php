<?php
	// requires php5
	// define('UPLOAD_DIR', 'images/');
	$img = $_POST['picture'];
	
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = uniqid() . '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';
?>
<!-- $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
$detectedType = exif_imagetype($_FILES['fupload']['tmp_name']);
$error = !in_array($detectedType, $allowedTypes); -->