<?php
	require 'connect.php';
	if (isset($_POST['submit'])) 
	{
		$j = 0;     // Variable for indexing uploaded image.
		$target_path = "uploads/";     // Declaring Path for uploaded images.
		for ($i = 0; $i < count($_FILES['file']['name']); $i++) 
		{
		// Loop to get individual element from the array
		$validextensions = array("jpeg", "jpg", "png");      // Extensions which are allowed.
		$ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
		$file_extension = end($ext); // Store extensions in the variable.
		$target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext) - 1];     // Set the target path with a new name of image.
		//$target_path = $target_path . md5(uniqid()). "." . $ext;
		$j = $j + 1;      // Increment the number of uploaded images according to the files in array.
		if (($_FILES["file"]["size"][$i] < 2000000)     // Approx. 100kb files can be uploaded.
			&& in_array($file_extension, $validextensions)) 
			{	
				$photoname = $_FILES['file']['tmp_name'][$i];
				$now = new DateTime();
				$today = $now->format('Y-m-d H:i:s');
				if (move_uploaded_file($photoname, $target_path)) {
				// If file moved to uploads folder.
				$sql = "INSERT INTO photo ( photo, date) VALUES ('$target_path', '$today')";	
				$result = mysql_query($sql);				
				if ($result) {
					echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
				}
				else{
				echo "can't insert to sql";
				}
				} 
				else 
				{     //  If File Was Not Moved.
				echo $j. ').<span id="error">please try again!.</span><br/><br/>';
				}
			} 
		else 
		{     	//   If File Size And File Type Was Incorrect.
			echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
		}
		}
	}
?>