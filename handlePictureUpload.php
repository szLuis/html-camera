<?php
	// requires php5
	define('UPLOAD_DIR', 'images/');
	if (count($_FILES) === 1){
		$img = $_FILES['data']['tmp_name'];	
	}else{
		$img = $_POST['picture'];
	}
	saveBlobAsImage($img);

	function saveDataUriImage($img)
	{
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR;// . uniqid() . '.png';
		$success = file_put_contents($file, $data);
		print $success ?  $_SERVER['SERVER_NAME'] . $_SERVER['host'] . "/" . $file : 'Unable to save the file.';
	}

	function saveBlobAsImage($imgSource){
		
		$destination = UPLOAD_DIR . uniqid() . '.png';
		$success = move_uploaded_file($imgSource, $destination);
		print $success ?  $_SERVER['SERVER_NAME'] . $_SERVER['host'] . "/" . $destination : 'Unable to save the file.';
	}
	

	/* $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
$detectedType = exif_imagetype($_FILES['fupload']['tmp_name']);
$error = !in_array($detectedType, $allowedTypes); */
?>
