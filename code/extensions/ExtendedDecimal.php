<?php
/**
 * extends the Decimal Field
 *
 * @package framework
 * @subpackage model
 */
class ExtendedDecimal extends DataExtension
{
    
    /**
     * returns the value formatet in the current locales currency format
     * 
     * @return string
     */
    public function Currency($symbol = false)
    {
        require_once THIRDPARTY_PATH."/Zend/Locale/Format.php";
        require_once THIRDPARTY_PATH."/Zend/Currency.php";
        
        if ($this->owner->value) {
            $locale = new Zend_Locale(i18n::get_locale());
            $number = Zend_Locale_Format::toNumber($this->owner->value, array('locale' => $locale));
            if ($symbol) {
                $symbol = new Zend_Currency($locale);
                $number = $symbol->getSymbol()." ".$number;
            }
            return $number;
        }
    }
}
