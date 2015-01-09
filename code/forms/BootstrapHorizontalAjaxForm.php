<?php
/**
 * Defines an Ajax submitted Form
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapHorizontalAjaxForm(
 *      $this->controller,
 * 	$name = "MyForm",
 * 	$fields,
 *      $actions,
 *      $validator
 * )
 * </code>
 * 
 * To customize the functionality you can overwrite the javascript
 * 
 * <code>
 * $name = $this->FormName();
 * $action = $this->FormAction().'/'.$controller->urlParams['ID'];
 * $loading = _t('BootstrapAjaxForm.LOADING', 'BootstrapAjaxForm.LOADING');
 * Requirements::block('BootstrapAjaxForm_Js_'.$this->FormName());
 * $js = <<<JS
 * (function($){
 *  $(function(){
 *      $('#{$name}').ajaxForm({
 *          delegation: true,
 *          target: '#AjaxForm_{$name}',
 *          beforeSubmit: function(data, form, options){
 *              $('#{$name} [type=submit]').prop("disabled", true).html('{$loading}');
 *          }
 *      });
 *  });
 * })(jQuery);
 * JS;
 * Requirements::customScript($js, 'Custom_BootstrapAjaxForm_Js_'.$this->FormName());
 * </code>
 * 
 * Also you can controll the return of your action
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
 * public function InheritedBootstrapAjaxForm(){
 *      // returnes the rendered form or the Form Object dependent on the request
 *      return InheritedBootstrapAjaxForm::create($this, "InheritedBootstrapAjaxForm")->AjaxReturn($this->request);
 * }
 * </code>
 * 
 * @package bootstrap_extra_fields
 * @subpackage forms
 */
class BootstrapHorizontalAjaxForm extends BootstrapAjaxForm {
    
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
        
        if(!Director::is_ajax()){
            Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
            Requirements::javascript('bootstrap_extra_fields/javascript/tooltip.js');
            $this->setTemplate('BootstrapHorizontalAjaxForm')->addExtraClass('form-horizontal');
        }else{
            $this->setTemplate('BootstrapHorizontalForm')->addExtraClass('form-horizontal');
        }
    }
}
