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

	if ( ! function_exists( 'exif_imagetype' ) ) {
		var_dump("no existe");
		function exif_imagetype ( $filename ) {
			if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) {
				return $type;
			}
		return false;
		}
	}

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
		try {
			$fileName = uniqid();
			$directory = getUploadDir();
			
			if (exif_imagetype($filePath)==IMAGETYPE_JPEG){
				$extension = ".jpg";
			}else if (exif_imagetype($filePath)==IMAGETYPE_PNG){
				$extension = ".png";
			}
			
			$destination = $directory . $fileName  . $extension;
			
			if ($extension===".jpg"){
				$success = move_uploaded_file($filePath, $destination);
			}else if ($extension===".png"){
				$destination = $directory . $fileName  . ".jpg";

				$image = imagecreatefrompng($filePath);
	
				// var_dump("IMAGE: " . $image);
				$bg = imagecreatetruecolor(imagesx($image), imagesy($image)); //create a black image from the specific measures
				imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
				imagealphablending($bg, TRUE);
				imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
				imagedestroy($image);
				$quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
		
				
				// $success = move_uploaded_file($imgSourceJPG, $destination);
		
				$success = imagejpeg($bg, $destination, $quality);
				imagedestroy($bg);
			}
			
			// $uploadedFile = UPLOAD_DIR . $fileName . ".png";
			// var_dump($uploadedFile);

			
	
			if ($success){
				$thumbnail = new ImageResize($destination);
				$thumbnail->resizeToWidth(160);
				$thumbnail->save(THUMBNAIL_DIR . $fileName   . ".jpg");
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
