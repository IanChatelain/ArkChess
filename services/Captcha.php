<?php

class Captcha{
    private $image;

    public function __construct(){
        $this->image = $this->generateCaptchaImage();
    }

    private function generateCaptchaImage(){
        $captcha_code = '';

        for($i = 0; $i < 6; $i++){
            $captcha_code .= chr(rand(97, 122));
        }

        $_SESSION['captcha'] = $captcha_code;
        $image = imagecreate(120, 40);
        $background = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        
        imagestring($image, 5, 5, 5, $captcha_code, $text_color);

        return $image;
    }

    public function outputImage(){
        if ($this->image === null){
            die('Image resource is null.');
        }
        header('Content-type: image/png');
        imagepng($this->image);
        imagedestroy($this->image);
    }
}

$captcha = new Captcha();
$captcha->outputImage();

?>
