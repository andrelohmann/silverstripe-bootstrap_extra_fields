<?php
/**
 * Defines a set of tabs in a form.
 * The tabs are build with our standard tabstrip javascript library.  
 * By default, the HTML is generated using FieldHolder.
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new TabSet(
 * 	$name = "TheTabSetName",
 * 	new Tab(
 * 		$title='Tab one',
 * 		new HeaderField("A header"),
 * 		new LiteralField("Lipsum","Lorem ipsum dolor sit amet enim.")
 * 	),
 * 	new Tab(
 * 		$title='Tab two',
 * 		new HeaderField("A second header"),
 * 		new LiteralField("Lipsum","Ipsum dolor sit amet enim.")
 * 	)
 * )
 * </code>
 * 
 * @package forms
 * @subpackage fields-structural
 */
class BootstrapHorizontalForm extends Form {
    
    public function IsHorizontal(){
        return true;
    }
    
    public function __construct($controller, $name, FieldList $fields, FieldList $actions, $validator = null){
         
        parent::__construct(
                $controller,
                $name,
                $fields,
                $actions,
                $validator
        );
        
        Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
        Requirements::javascript('bootstrap_extra_fields/javascript/tooltip.js');
        
        $this->setTemplate('BootstrapHorizontalForm')->addExtraClass('form-horizontal');
    }
    
}
