<?php
/**
 * The action buttons are <input type="submit"> as well as <button> tags.
 * 
 * Upon clicking the button below will redirect the user to doAction under the current controller.
 * 
 * <code>
 * new FormAction (
 *    // doAction has to be a defined controller member
 *    $action = "doAction",
 *    $title = "Submit button"
 * )
 * </code>
 * 
 * @package forms
 * @subpackage actions
 */
class BootstrapModalFormAction extends FormAction {

	protected $target;
	
	/**
	 * Enables the use of <button> instead of <input>
	 * in {@link Field()} - for more customizeable styling.
	 * 
	 * @var boolean $useButtonTag
	 */
	public $useButtonTag = false;
	
	protected $buttonContent = null;
	
	/**
	 * Create a new action button.
	 *
	 * @param action The method to call when the button is clicked
	 * @param title The label on the button
	 * @param form The parent form, auto-set when the field is placed inside a form 
	 */
	public function __construct($title = "") {
		$this->action = "action_modalToggle";
		
		parent::__construct($this->action, $title, null, null);
	}

	public function setTarget($target) {
		$this->target = $target;
                return $this;
	}
        
        public function getTarget(){
            return $this->target;
        }

}
