<?php

print($_POST);
if (isset($_POST)){

if (!empty($_FILES['s_image']['name'])) {
	if(is_array($_FILES)) {
	if($_FILES['s_image']['name']!=''){
	if(is_uploaded_file($_FILES['s_image']['tmp_name'])) {
		$sourcePath = $_FILES['s_image']['tmp_name'];
		$name = time()."_".$_FILES['s_image']['name'];
		$targetPath = "student_images/".$name;
			if(move_uploaded_file($sourcePath,$targetPath)) {
			echo "Done";
			}
}
}
 }

   } else {
    print 'Please select a file to upload.';
}} else {
echo 'Nothing was sent';
}
?>