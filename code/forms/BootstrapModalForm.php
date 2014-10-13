<?php
/**
 * Defines a Modal Form
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapModalForm(
 *      $this->controller,
 * 	$name = "MyForm",
 * 	$fields,
 *      $actions,
 *      $validator,
 *      $title = 'My Form Modal Title',
 *      new BootstrapModalFormAction($Title = 'Open My Modal Form')
 * )
 * </code>
 * 
 * @package bootstrap_extra_fields
 * @subpackage forms
 */
class BootstrapModalForm extends Form {
    
    protected $ModalFormAction;
    protected $title;
    
    protected $size = 'normal';
    
    public function hasErrors(){
        $errorInfo = Session::get("FormInfo.{$this->FormName()}");
        
        if(isset($errorInfo['errors']) && is_array($errorInfo['errors'])){
            return true;
        }
        
        if(isset($errorInfo['message']) && isset($errorInfo['type'])) {
            return true;
        }
        
        return false;
    }
    
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function setSize($size = 'normal'){
        switch($size){
            case 'large':
                $this->size = 'large';
            break;
        
            case 'small':
                $this->size = 'small';
            break;
        
            default:
                $this->size = 'normal';
            break;
        }
        return $this;
    }
    
    public function setLarge(){
        $this->size = 'large';
        return $this;
    }
    
    public function setSmall(){
        $this->size = 'small';
        return $this;
    }
    
    public function setNormal(){
        $this->size = 'normal';
        return $this;
    }
    
    public function getSize(){
        switch($this->size){
            case 'large':
                return 'modal-lg';
            break;
        
            case 'small':
                return 'modal-sm';
            break;
        
            default:
                return '';
            break;
        }
    }
    
    public function __construct($controller, $name, FieldList $fields, FieldList $actions, $validator = null, $Title = '', BootstrapModalFormAction $ModalFormAction){
         
        parent::__construct(
                $controller,
                $name,
                $fields,
                $actions,
                $validator
        );
        
        $this->setTitle($Title);
        
        $this->ModalFormAction = $ModalFormAction;
        $this->ModalFormAction->setTarget("Modal_".$this->FormName());
        
        if($this->hasErrors()){
            // set Modal open
            $name = $this->FormName();
            $js = <<<JS
$(function () {
    $('#Modal_{$name}').modal('show');
});
JS;
            Requirements::customScript($js);
        }
        
        $this->setTemplate('BootstrapModalForm');
    }
    
}
