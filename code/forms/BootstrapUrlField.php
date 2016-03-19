<?php

/**
 * Text input field with validation for correct url format
 *
 * @package bootstrap_extra_fields
 */
class BootstrapUrlField extends TextField {
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

		$pattern = '(\b(https?)://)?[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]';

		// Escape delimiter characters.
		$safePattern = str_replace('/', '\\/', $pattern);

		if($this->value && !preg_match('/' . $safePattern . '/i', $this->value)) {
			$validator->validationError(
				$this->name,
				_t('BootstrapUrlField.VALIDATION', 'Please enter a valid URL'),
				'validation'
			);

			return false;
		}

		return true;
	}
}
