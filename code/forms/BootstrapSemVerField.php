<?php
/**
 * BootstrapSemVerField provides an easy way of validating a semantic version number.
 * 
 * @package bootstrap_extra_fields
 * @subpackage fields
 */

class BootstrapSemVerField extends TextField {

	public function validate($validator) {
		if(!$this->value && !$validator->fieldIsRequired($this->name)) {
			return true;
		}
		
		$parser = new League\SemVer\RegexParser();
		
		if($parser->isValidVersion($this->value)){
            return true;
        }

		$validator->validationError(
			$this->name,
			_t('BootstrapSemVerField.VALIDATION', "Invalid version number."),
			"validation"
		);
		return false;
	}
}