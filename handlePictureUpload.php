<?php
error_reporting(E_ALL);
	// requires php5
	require_once  'vendor/autoload.php';
	use Gumlet\ImageResize;
	
	define('UPLOAD_DIR', 'images/');
	define('THUMBNAIL_DIR', 'thumbnails/');

	if (count($_FILES) === 1){
		$img = $_FILES['data']['tmp_name'];	
	}else{
		$img = $_POST['picture'];
	}

	// saveBlobAsImage($img);
	savePNGtoJPG($img);

	function saveDataUriImage($img)
	{
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR;// . uniqid() . '.png';
		$success = file_put_contents($file, $data);
		print $success ?  $_SERVER['SERVER_NAME'] . $_SERVER['host'] . "/" . $file : 'Unable to save the file.';
	}

	// function saveBlobAsImage($imgSource){
	// 	$imgSourceJPG=savePNGtoJPG($imgSource);
		
		
	// 	if ($success){
	// 		$thumbnail = new ImageResize($destination);
	// 		$thumbnail->resizeToWidth(160);
	// 		$thumbnail->save(THUMBNAIL_DIR . $fileName);
	// 	}
	// 	print $success ?  $_SERVER['SERVER_NAME'] .  "/" . $destination : 'Unable to save the file.';
	// }

	function savePNGtoJPG($filePath){
		var_dump($filePath);

		try {
			$image = imagecreatefrompng($filePath);
			var_dump($image);
			$bg = imagecreatetruecolor(imagesx($image), imagesy($image)); //create a black image from the specific measures
			$fill = imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			$alpha=imagealphablending($bg, TRUE);
			$copy  = imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
			$destroy=imagedestroy($image);
			$quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
	
			var_dump($fill,$alpha,$copy,$destroy);
			$directory = getUploadDir();
			$fileName = uniqid() . '.jpg';
			$destination = $directory . $fileName;
			// $success = move_uploaded_file($imgSourceJPG, $destination);
	
			$success = imagejpeg($bg, $destination, $quality);
			var_dump($success);
			
	
			if ($success){
				imagedestroy($bg);
				$thumbnail = new ImageResize($destination);
				$thumbnail->resizeToWidth(160);
				$thumbnail->save(THUMBNAIL_DIR . $fileName);
			}
			print $success ?  $_SERVER['SERVER_NAME'] .  "/" . $destination : 'Unable to save the file.';
		} catch (Exception $e) {
			print $e->getMessage() . $e->getCode();
		}
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
