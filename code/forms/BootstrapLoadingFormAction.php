<?php
/**
 * Two masked input fields, checks for matching passwords.
 * Optionally hides the fields by default and shows
 * a link to toggle their visibility.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class BootstrapLoadingFormAction extends FormAction {
    
    protected $sendingMessage;
    
    /**
     * 
     * Create a new action button.
     *
     * @param action The method to call when the button is clicked
     * @param title The label on the button
     * @param form The parent form, auto-set when the field is placed inside a form 
     */
    public function __construct($action, $title = "", $form = null){
        parent::__construct($action, $title, $form);
        
        $this->sendingMessage = _t('BootstrapLoadingFormAction.LOADING', 'BootstrapLoadingFormAction.LOADING');
    }
    
    public function Field($properties = array()) {
        $this->setAttribute('onclick', "javascript:(function(that){setTimeout(function(){if(that.form.checkValidity()){that.disabled=true;that.innerHTML='" .$this->sendingMessage."';}},0);})(this);");
        return parent::Field($properties);
    }
    
    public function setSendingMessage($message){
        $this->sendingMessage = $message;
        return $this;
    }
    
    public function getSendingMessage(){
        return $this->sendingMessage;
    }
}
