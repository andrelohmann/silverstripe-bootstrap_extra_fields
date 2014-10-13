<?php
/**
 * Defines a Horizontal Modal Form
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapHorizontalModalForm(
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
class BootstrapHorizontalModalForm extends BootstrapModalForm {
    
    public function IsHorizontal(){
        return true;
    }
    
    public function __construct($controller, $name, FieldList $fields, FieldList $actions, $validator = null, $Title = '', BootstrapModalFormAction $ModalFormAction){
         
        parent::__construct(
                $controller,
                $name,
                $fields,
                $actions,
                $validator,
                $Title,
                $ModalFormAction
        );
        
        Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
        Requirements::javascript('bootstrap_extra_fields/javascript/tooltip.js');
        
        $this->setTemplate('BootstrapHorizontalModalForm')->addExtraClass('form-horizontal')->setLarge();
    }
    
}
