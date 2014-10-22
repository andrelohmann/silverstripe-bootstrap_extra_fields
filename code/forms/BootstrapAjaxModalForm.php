<?php
/**
 * Defines an Ajax submitted Form within a Bootstrap Modal Window
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapAjaxModalForm(
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
 * To customize the functionality you can overwrite the javascript
 * 
 * <code>
 * $name = $this->FormName();
 * $action = $this->FormAction().'/'.$controller->urlParams['ID'];
 * Requirements::block('BootstrapAjaxModalForm_Js');
 * $js = <<<JS
 * (function($){
 *  $(function(){
 *      $('#{$name}').ajaxForm({
 *          delegation: true,
 *          target: '#Modal_{$name} .modal-dialog .modal-content',
 *          beforeSubmit: function(data, form, options){
 *              $('#{$name} [type=submit]').prop("disabled", true);
 *          }
 *      });
 *  });
 *  $(function(){
 *      $('#Modal_{$name}').on('show.bs.modal', function(e){
 *          $('#Modal_{$name} .modal-dialog .modal-content').load('{$action}');
 *      });
 *      $('#Modal_{$name}').on('hidden.bs.modal', function(e){
 *          $('#Modal_{$name} .modal-dialog .modal-content').html('');
 *      });
 *  });
 * })(jQuery);
 * JS;
 * Requirements::customScript($js, 'Custom_BootstrapAjaxModalForm_Js');
 * </code>
 * 
 * Also you can controll the retur of your action
 * 
 * <code>
 * public function doSend(array $data){
 *      // Do some stuff
 *      // clear messages
 *      $this->clearMessage();
 *      // clear some form fields
 *      $this->loadDataFrom(array('Title' => null, 'Text' => null));
 *      // add some success message
 *      $this->setMessage('You Message has been send', 'good');
 *      // return the rendered Form for Ajax
 *      return $this->forAjaxTemplate();
 * }
 * </code>
 * 
 * In the Controller the Form needs to be returned by AjaxReturn Method
 * 
 * <code>
 * public function InheritedBootstrapAjaxModalForm(){
 *      // returnes the rendered form or the Form Object dependent on the request
 *      return InheritedBootstrapAjaxModalForm::create($this, "InheritedBootstrapAjaxModalForm")->AjaxReturn($this->request);
 * }
 * </code>
 * 
 * @package bootstrap_extra_fields
 * @subpackage forms
 */
class BootstrapAjaxModalForm extends BootstrapModalForm {
    
    
    
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
        
        Requirements::block('BootstrapModalForm_hasErrorJs');
        Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-form/jquery.form.js');
        
        $name = $this->FormName();
        $action = $this->FormAction();
        $js = <<<JS
(function($){
    $(function(){
        $('#{$name}').ajaxForm({
            delegation: true,
            target: '#Modal_{$name} .modal-dialog .modal-content',
            beforeSubmit: function(data, form, options){
                $('#{$name} [type=submit]').prop("disabled", true);
            }
	});
    });
    
    $(function(){
        $('#Modal_{$name}').on('show.bs.modal', function(e){
            $('#Modal_{$name} .modal-dialog .modal-content').load('{$action}');
        });
        $('#Modal_{$name}').on('hidden.bs.modal', function(e){
            $('#Modal_{$name} .modal-dialog .modal-content').html('');
        });
    });
})(jQuery);
JS;
        Requirements::customScript($js, 'BootstrapAjaxModalForm_Js');
        
        if(Director::is_ajax()) $this->setTemplate('BootstrapAjaxModalForm');
    }

	/**
	 * Return a rendered version of this form, suitable for ajax post-back.
	 * It triggers slightly different behaviour, such as disabling the rewriting of # links
	 */
	public function forAjaxTemplate() {
		$view = new SSViewer(array(
			$this->getTemplate(),
			'Form'
		));
                
                $return = $view->dontRewriteHashlinks()->process($this);
                
                // Now that we're rendered, clear message
		$this->clearMessage();

		return $return;
	}
        
        public function AjaxReturn($request){
            if(!Director::is_ajax()){
                return $this;
            }else{
                if($this->examineFormAction($request)) return $this;
                else return $this->forAjaxTemplate();
            }
            
        }
        
        protected function examineFormAction($request){
            // Determine the action button clicked
            $actionSet = false;
            foreach($request->requestVars() as $paramName => $paramVal){
                if(substr($paramName,0,7) == 'action_'){
                    $actionSet = true;
                    break;
		}
            }
            return $actionSet;
        }
    
}
