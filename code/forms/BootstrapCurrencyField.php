<?php

/**
 * Text input field with validation for numeric values. Supports validating
 * the numeric value as to the {@link i18n::get_locale()} value.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapCurrencyField extends NumericField {
    
	/**
	 * displays the value in its current locality format
	 */
	public function setValue($value, $data = array()) {
		require_once THIRDPARTY_PATH."/Zend/Locale/Format.php";

		// If passing in a non-string number, or a value
		// directly from a dataobject then localise this number
		if ((is_numeric($value) && !is_string($value)) || 
			($value && $data instanceof DataObject)
		){
			$locale = new Zend_Locale($this->getLocale());
			$this->value = Zend_Locale_Format::toNumber($value, array('locale' => $locale));
		}else if(Zend_Locale_Format::isNumber(
            $this->clean($value), 
			array('locale' => i18n::get_locale())
        )){
			// If an invalid number, store it anyway, but validate() will fail
			$this->value = $this->clean($value);
		}
		return $this;
	}
	
        /**
         * extracts the 
         * @return type
         */
	public function dataValue() {
		
		require_once THIRDPARTY_PATH."/Zend/Locale/Format.php";
                
        $locale = new Zend_Locale(i18n::get_locale());
        $number = Zend_Locale_Format::getNumber($this->value, array('locale' => $locale));
		return $number;
	}
        
	public function CurrencySymbol(){

		require_once THIRDPARTY_PATH."/Zend/Currency.php";

		$locale = new Zend_Locale(i18n::get_locale());
		$symbol = new Zend_Currency($locale);
		return $symbol->getSymbol();
	}

	public function setEmpty(){
		$this->value = null;
	}
}
