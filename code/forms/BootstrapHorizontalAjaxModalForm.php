<?php
/**
 * Defines an Ajax submitted Form within a Bootstrap Modal Window
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapHorizontalAjaxModalForm(
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
class BootstrapHorizontalAjaxModalForm extends BootstrapAjaxModalForm {
    
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
        
        if(Director::is_ajax()){
            $this->setTemplate('BootstrapHorizontalAjaxModalForm')->addExtraClass('form-horizontal');
        }else{
            Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
            Requirements::javascript('bootstrap_extra_fields/javascript/tooltip.js');
            $this->setTemplate('BootstrapHorizontalModalForm')->addExtraClass('form-horizontal')->setLarge();
        }
    }
    
}
