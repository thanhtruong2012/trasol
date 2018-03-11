<?php  
/**
 * Class File
 * Contain all system or common method.
 * @category Libraries Files
 * @package Libraries
 * @author LP (Le Van Phu) <vanphupc50@gmail.com>
 * @version 1.0
 */

class File
{
	
	public static function fileExists($fileName, $caseSensitive = true)
	{

	    if(file_exists($fileName)) {

	        return $fileName;

	    }

	    if($caseSensitive) return false;



	    // Handle case insensitive requests            

	    $directoryName = dirname($fileName,2);

	    $fileArray = glob($directoryName . '/*', GLOB_NOSORT);

	    $fileNameLowerCase = strtolower($fileName);

	    foreach($fileArray as $file) {

	        if(strtolower($file) == $fileNameLowerCase) {

	            return $file;

	        }

	    }

	    return false;
	}
}
?>