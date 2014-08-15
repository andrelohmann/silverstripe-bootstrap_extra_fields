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
	public function setValue($val) {
                
                require_once THIRDPARTY_PATH."/Zend/Locale/Format.php";
                    
		if(is_numeric($val)){		
                    $locale = new Zend_Locale(i18n::get_locale());
                    $this->value = Zend_Locale_Format::toNumber($val, array('locale' => $locale));
                }else if(Zend_Locale_Format::isNumber(
                        trim($val), 
			array('locale' => i18n::get_locale())
                )){
                    $this->value = trim($val);
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
