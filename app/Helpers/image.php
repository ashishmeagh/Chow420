<?php 



//this function for image resize

function image_resize($path,$width = false,$height = false,$image_type=false,$default_image = false)
{ 
 
	// $base_dir = dirname($path);
	// $base_dir = ltrim($base_dir,"/");
	// $base_dir_with_basepath = base_path($base_dir);
	
	// $base_file = basename($path);
	
	// $resized_dir = $base_dir.DIRECTORY_SEPARATOR."resized".DIRECTORY_SEPARATOR.$width."x".$height;
	// $resized_dir_with_basepath = base_path($resized_dir);

	// if(is_dir($resized_dir_with_basepath) == false)
	// {
	// 	mkdir($resized_dir_with_basepath,0777,true);	
	// 	chmod($resized_dir_with_basepath,0777);	
	// }

	// $resized_path = $resized_dir.DIRECTORY_SEPARATOR.$base_file;
	// $resized_path_with_basepath = $resized_dir_with_basepath.DIRECTORY_SEPARATOR.$base_file;
	

	// if(is_readable($resized_path_with_basepath))
	// { 

	// 	//return url($resized_path);
		
	// 	return url($path);
	// }

	// try
	// {
        
	// 	$canvas = Image::canvas($width, $height);
	// 	$image  = Image::make(base_path($path))->resize($width, $height, function($constraint)
	// 	{
	// 	    $constraint->aspectRatio();
	// 	});
	// 	$canvas->insert($image, 'center');

	// 	$canvas->save($resized_dir_with_basepath.DIRECTORY_SEPARATOR.$base_file,100,'jpg');


	// 	return url($resized_path);
	// }
	// catch(\Exception $e)
	// { 
		
	// 	return url('/assets/images/default-product-image.png');
	// }

	return url($path);

}




?>