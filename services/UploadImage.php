<?php

use Gumlet\ImageResize;

class UploadImage{
    /**
     * Determines the file path for uploaded files based on their size category.
     *
     * @param string $fileName The original name of the file being uploaded.
     * @param Size|null $size The size category of the file, if applicable.
     * @return string The file path where the uploaded file should be stored.
     */
    public static function uploadPath($fileName, ?Size $size = NULL){
        $uploadDirectory = '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'uploads';
        $currentDirectory = dirname(__FILE__);

        if($size !== null){
            switch($size){
                case Size::MEDIUM:
                    $uploadDirectory .= DIRECTORY_SEPARATOR . 'medium';
                    break;
                case Size::THUMBNAIL:
                    $uploadDirectory .= DIRECTORY_SEPARATOR . 'thumbnail';
                    break;
            }
        }

        
        $segments = [$currentDirectory, $uploadDirectory, basename($fileName)];
        return join(DIRECTORY_SEPARATOR, $segments);
    }

    /**
     * Resizes an image to predetermined sizes and saves it.
     *
     * @param string $tempFilePath The temporary file path of the uploaded image.
     * @param Size $size The size category to which the image should be resized.
     * @return void
     */
    protected static function resizeImage($tempFilePath, Size $size){
        $fileInfo = pathinfo($tempFilePath);
        $newFileName = sprintf("%s_%s", $fileInfo['filename'], strtolower($size->name));

        if(isset($fileInfo['extension'])){
            $newFileName .= '.' . $fileInfo['extension'];
        }

        $newFilePath = self::uploadPath($newFileName, $size);

        $image = new ImageResize($tempFilePath);

        switch($size){
            case Size::MEDIUM:
                $image->resizeToWidth(250);
                $_SESSION['img_med'] = $newFileName;
                break;
            case Size::THUMBNAIL:
                $image->resizeToWidth(50);
                $_SESSION['img_thumb'] = $newFileName;
                break;
        }

        $image->save($newFilePath);
    }

    /**
     * Validates if the file type of an uploaded file is allowed.
     *
     * @param string $tempFilePath The temporary file path of the uploaded file.
     * @return bool True if the file type is valid, false otherwise.
     */
    protected static function isValidFileType($tempFilePath){
        $allowedMimeTypes = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
        $finfo = new finfo();
        $mimeType = $finfo->file($_FILES['file']['tmp_name'], FILEINFO_MIME_TYPE);
        $isValid = in_array($mimeType, $allowedMimeTypes);

        return $isValid;
    }

    public static function executeResize(){
        $errorCode = 0;
        if(isset($_FILES['file']) && ($_FILES['file']['error'] === 0)){
            $fileName = $_FILES['file']['name'];
            $tempFilePath = $_FILES['file']['tmp_name'];
        
            if(self::isValidFileType($tempFilePath)){
                $uniqueString = md5(uniqid(rand(), true));
                $fileInfo = pathinfo($fileName);
                $baseName = $fileInfo['filename']; // might need to check if these are set
                $extension = $fileInfo['extension'];
                $newFileName = sprintf("%s_%s.%s", $baseName, $uniqueString, $extension);
                if($_FILES['file']['type'] == "application/pdf"){
                    $newFilePath = self::uploadPath($newFileName);
                    if(!move_uploaded_file($tempFilePath, $newFilePath)){
                        $errorCode = -100; // Unable to upload.
                    }
                }
                else{
                    $newFilePath = self::uploadPath($newFileName);
                    $_SESSION['img_org'] = $newFileName;
                    if(move_uploaded_file($tempFilePath, $newFilePath)){
                        self::resizeImage($newFilePath, Size::MEDIUM);
                        self::resizeImage($newFilePath, Size::THUMBNAIL);
                    }
                    else{
                        $errorCode = -100; // Unable to upload.
                    }
                }
            } 
            else{
                $errorCode = -200; // Invalid file type
            }
        }
        return $errorCode;
    }
}

?>