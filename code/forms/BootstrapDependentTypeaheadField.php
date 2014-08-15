<?php

/**
 * Text input field with validation for numeric values. Supports validating
 * the numeric value as to the {@link i18n::get_locale()} value.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapDependentTypeaheadField extends TextField {

	public static $allowed_actions = array(
		'load'
	);

	protected $depends;

	protected $source;

	public function load($request) {
		$response = new SS_HTTPResponse();
		$response->addHeader('Content-Type', 'application/json');
		$response->setBody(Convert::array2json(call_user_func(
			$this->source, $request->getVar('val'), $request->getVar('dependentval')
		)));
		return $response;
	}

	public function getDepends() {
		return $this->depends;
	}

	public function setDepends(FormField $field) {
		$this->depends = $field;
		return $this;
	}

	public function setSource($source) {
		if(!is_callable($source)) {
			die('Source on BootstrapTypeaheadField needs to be an executable method');
		}
                
                $this->source = $source;
                return $this;
	}

	public function Field($properties = array()) {
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/bootstrap3-typeahead.min.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/bootstrapdependenttypeaheadfield.js');

		$this->addExtraClass('dependenttypeahead');
		$this->setAttribute('autocomplete', 'off');
		$this->setAttribute('data-link', $this->Link('load'));
		$this->setAttribute('data-depends', $this->getDepends()->getName());

		return parent::Field($properties);
	}
}