<?php
/**
 * BootstrapCaptchaField provides an easy way of validation Forms by Captcha.
 * 
 * @package bootstrap_extra_fields
 * @subpackage fields
 */

class BootstrapCaptchaField extends TextField {
	
	/**
	 * Returns an input field, class="text" and type="text" with an optional maxlength
	 */
	public function __construct($name, $title = null, $value = '', $maxLength = null, $form = null) {
		$this->setAttribute('placeholder', _t('BootstrapCaptchaField.PLACEHOLDER', "Type the code shown"));
		
		parent::__construct($name, $title, $value, $form);
	}
    
	protected function GenerateImage($string){
		$image = imagecreatetruecolor(200, 50);

		$background_color = imagecolorallocate($image, 255, 255, 255);  
		imagefilledrectangle($image,0,0,200,50,$background_color);

		$line_color = imagecolorallocate($image, 128,128,128); 
		for($i=0;$i<5;$i++) {
			imageline($image,0,rand()%50,200,rand()%50,$line_color);
		}

		$pixel_color = imagecolorallocate($image, 0,0,128);
		for($i=0;$i<500;$i++) {
			imagesetpixel($image,rand()%200,rand()%50,$pixel_color);
		}

		$pixel_color = imagecolorallocate($image, 128,0,0);
		for($i=0;$i<500;$i++) {
			imagesetpixel($image,rand()%200,rand()%50,$pixel_color);
		}

		$text_color = imagecolorallocate($image, 255,0,0);
		$i=0;
		foreach(str_split($string) as $letter){
			imagestring($image, 5,  5+($i*30), 20, $letter, $text_color);
			$i++;
		}

		$resized = imagecreatetruecolor(300, 75);

		imagecopyresampled($resized, $image, 0, 0, 0, 0, 300, 75, 200, 50);

		ob_start();
		imagepng($resized);
		$contents = ob_get_contents();
		ob_end_clean();

		$Base64Image = base64_encode($contents);

		imagedestroy($image);

		return "data:image/png;base64,".$Base64Image;
	}

	protected function GenerateString(){
		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$len = strlen($letters);
		$captcha = '';
		for ($i = 0; $i< 6;$i++) {
			$letter = $letters[rand(0, $len-1)];
			$captcha.=$letter;
		}
		return $captcha;
	}

	public function Field($properties = array()) {
            
        // Fetch the Field Record
        $CaptchaValue = $this->GenerateString();
        
        Session::set('BootstrapCaptchaFieldValue', $CaptchaValue);
        $ImageSrc = $this->GenerateImage($CaptchaValue);
            
	    $properties = array_merge($properties, array(
            'ImageSrc' => $ImageSrc
        ));
		
        return parent::Field($properties);
	}

	public function validate($validator) {
		if(!$this->value && !$validator->fieldIsRequired($this->name)) {
			return true;
		}
		
		if(strtolower($this->value) == strtolower(Session::get('BootstrapCaptchaFieldValue'))){
            $this->value == '';
            Session::clear('BootstrapCaptchaFieldValue');
            return true;
        }

		$validator->validationError(
			$this->name,
			_t('BootstrapCaptchaField.VALIDATION', "Invalid code, try again."),
			"validation"
		);
		return false;
	}
}