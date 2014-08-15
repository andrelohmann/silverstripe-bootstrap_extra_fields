<?php

/**
 * Text input field with validation for numeric values. Supports validating
 * the numeric value as to the {@link i18n::get_locale()} value.
 * 
 * http://eonasdan.github.io/bootstrap-datetimepicker/
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapDatetimepickerField extends TextField {
    
        protected $locale = false;
        
        protected $supported_locales = array(
            'de_DE' => 'de',
            'en_GB' => 'en-gb'
        );
        
        protected $locale_formats = array(
            'en_US' => 'm/d/Y g:i A', //
            'de_DE' => 'd.m.Y G:i \U\h\r',
            'en_GB' => 'd/m/Y H:i' // falls das brittische Datum nicht geschrieben wird, kann es an einer fehlenden null vor der Stunde liegen. Einfach "H" durch "G" ersetzen
        );
        
        //protected $formats = array(
        //    'de_DE' => '',
        //    'en_GB' => 'en-gb'
        //);
	
	public function Field($properties = array()) {
        
                Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/moment.min.js');
		Requirements::javascript('bootstrap_extra_fields/javascript/bootstrap-datetimepicker.min.js');
		Requirements::css('bootstrap_extra_fields/css/bootstrap-datetimepicker.min.css');
                
                $language = '';
                if(array_key_exists(i18n::get_locale(), $this->supported_locales)){
                    Requirements::javascript('bootstrap_extra_fields/javascript/locales/bootstrap-datetimepicker.'.$this->supported_locales[i18n::get_locale()].'.js');
                    $language = "language: '{$this->supported_locales[i18n::get_locale()]}'";
                }else if($this->locale){
                    Requirements::javascript('bootstrap_extra_fields/javascript/locales/bootstrap-datetimepicker.'.$this->locale.'.js');
                    $language = "language: '{$this->locale}'";
                }
		
		$name = $this->ID();
		
		// set caption if required
		$js = <<<JS
$(function () {
    $('#{$name}').datetimepicker({{$language}});
});
JS;
		Requirements::customScript($js);
                
                return parent::Field($properties);
	}
        
        public function setLocale($locale){
            $this->locale = $locale;
        }
        
        public function getLocale(){
            return $this->locale;
        }
        
        protected function validateDate($date, $format = 'Y-m-d H:i:s'){
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;
        }
        
        protected function getFormat(){
            if(array_key_exists(i18n::get_locale(), $this->supported_locales)) $locale = i18n::get_locale();
            else $locale = 'en_US';
            
            return $this->locale_formats[$locale];
        }
    
	/**
	 * displays the value in its current locality format
	 */
	public function setValue($val) {
		
            //require_once THIRDPARTY_PATH."/Zend/Locale/Format.php";
            //require_once THIRDPARTY_PATH."/Zend/Date.php";
            
            if(is_numeric($val) && (int)$val == $val){
                // is Timestamp
                $this->value = date($this->getFormat(), (int)$val);
            }else if($this->validateDate($val, 'Y-m-d H:i:s')){
                // is Time from Database
                $d = DateTime::createFromFormat('Y-m-d H:i:s', $val);
                $this->value = $d->format($this->getFormat());
            }else if($this->validateDate($val, $this->getFormat())){
                $d = DateTime::createFromFormat($this->getFormat(), $val);
                $this->value = $d->format($this->getFormat());
            }
            
            return $this;
	}
	
        /**
         * extracts the 
         * @return type
         */
	public function dataValue() {
            if($this->value){
                $d = DateTime::createFromFormat($this->getFormat(), $this->value);
                return $d->format('Y-m-d H:i:s');
            }
	}

	/**
	 * @return Boolean
	 */
	public function validate($validator) {
		/*$valid = true;
		
		// Don't validate empty fields
		if(empty($this->value)) return true;

		// date format
		if($this->getConfig('dmyfields')) {
			$valid = (!$this->value || $this->validateArrayValue($this->value));
		} else {
			$valid = (Zend_Date::isDate($this->value, $this->getConfig('dateformat'), $this->locale));
		}
		if(!$valid) {
			$validator->validationError(
				$this->name, 
				_t(
					'DateField.VALIDDATEFORMAT2', "Please enter a valid date format ({format})", 
					array('format' => $this->getConfig('dateformat'))
				), 
				"validation", 
				false
			);
			return false;
		}
		
		// min/max - Assumes that the date value was valid in the first place
		if($min = $this->getConfig('min')) {
			// ISO or strtotime()
			if(Zend_Date::isDate($min, $this->getConfig('datavalueformat'))) {
				$minDate = new Zend_Date($min, $this->getConfig('datavalueformat'));
			} else {
				$minDate = new Zend_Date(strftime('%Y-%m-%d', strtotime($min)), $this->getConfig('datavalueformat'));
			}
			if(!$this->valueObj || (!$this->valueObj->isLater($minDate) && !$this->valueObj->equals($minDate))) {
				$validator->validationError(
					$this->name, 
					_t(
						'DateField.VALIDDATEMINDATE',
						"Your date has to be newer or matching the minimum allowed date ({date})", 
						array('date' => $minDate->toString($this->getConfig('dateformat')))
					),
					"validation", 
					false
				);
				return false;
			}
		}
		if($max = $this->getConfig('max')) {
			// ISO or strtotime()
			if(Zend_Date::isDate($min, $this->getConfig('datavalueformat'))) {
				$maxDate = new Zend_Date($max, $this->getConfig('datavalueformat'));
			} else {
				$maxDate = new Zend_Date(strftime('%Y-%m-%d', strtotime($max)), $this->getConfig('datavalueformat'));
			}
			if(!$this->valueObj || (!$this->valueObj->isEarlier($maxDate) && !$this->valueObj->equals($maxDate))) {
				$validator->validationError(
					$this->name, 
					_t('DateField.VALIDDATEMAXDATE',
						"Your date has to be older or matching the maximum allowed date ({date})", 
						array('date' => $maxDate->toString($this->getConfig('dateformat')))
					),
					"validation", 
					false
				);
				return false;
			}
		}
		*/
		return true;
	}
}
