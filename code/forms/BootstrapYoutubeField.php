<?php

/**
 * Text input field with validation for correct url format
 *
 * @package bootstrap_extra_fields
 */
class BootstrapYoutubeField extends TextField {
	/**
	 * {@inheritdoc}
	 */
	public function Type() {
		return 'url text';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttributes() {
		return array_merge(
			parent::getAttributes(),
			array(
				'type' => 'url',
			)
		);
	}

	/**
	 * Validates for RFC 2822 compliant email addresses.
	 *
	 * @see http://www.regular-expressions.info/email.html
	 * @see http://www.ietf.org/rfc/rfc2822.txt
	 *
	 * @param Validator $validator
	 *
	 * @return string
	 */
	public function validate($validator) {
		$this->value = trim($this->value);
                
                if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $this->value, $id)) {
                    $video = $id[1];
                } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $this->value, $id)) {
                    $video = $id[1];
                } else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $this->value, $id)) {
                    $video = $id[1];
                } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $this->value, $id)) {
                    $video = $id[1];
                } else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $this->value, $id)) {
                    $video = $id[1];
                } else if($video_url = @file_get_contents('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v='.$this->value)){
                    $video = $this->value;
                } else {   
                    $video = false;
                }

		if($this->value && !$video) {
			$validator->validationError(
				$this->name,
				_t('BootstrapYoutubeField.VALIDATION', 'Please enter a valid Youtube Video URL'),
				'validation'
			);

			return false;
		}
                
                $this->value = $video;

		return true;
	}
}
