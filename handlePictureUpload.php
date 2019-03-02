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
		$directory = getUploadDir();
		$destination = $directory . uniqid() . '.png';
		$success = move_uploaded_file($imgSource, $destination);
		print $success ?  $_SERVER['SERVER_NAME'] .  "/" . $destination : 'Unable to save the file.';
	}

	/**
	 * Verifies if the directory for the current date exists,
	 * if it extists returns the path if not the creates it and returns the path.
	 * @return String The path of the upload dir for the current date.
	 */
	function getUploadDir(){
		$path = UPLOAD_DIR . date("Y-m-d") . "/";
		if (file_exists($path)){
			return  $path;
		}else{
			if (createNewDir($path)){
				return $path;
			}else{
				return "Error";
			}
		}
	}
	
	/**
	 * Creates a new directory under the UPLOAD_DIR
	 * the name is based on date.
	 * 
	 * @return Boolean True on success or false on failure
	 */
	function createNewDir($path)
	{
		return mkdir($path, 0755, true);
	}

	/* $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
$detectedType = exif_imagetype($_FILES['fupload']['tmp_name']);
$error = !in_array($detectedType, $allowedTypes); */
?>
