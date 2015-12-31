<?php
/**
 * Defines an Ajax submitted Form
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new BootstrapAjaxForm(
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
class BootstrapAjaxForm extends Form
{
    
    
    
    public function __construct($controller, $name, FieldList $fields, FieldList $actions, $validator = null)
    {
        parent::__construct(
                $controller,
                $name,
                $fields,
                $actions,
                $validator
        );
        
        Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-form/jquery.form.js');
        
        $name = $this->FormName();
        $action = $this->FormAction();
        $loading = _t('BootstrapAjaxForm.LOADING', 'BootstrapAjaxForm.LOADING');
        $js = <<<JS
(function($){
    $(function(){
        $('#{$name}').ajaxForm({
            delegation: true,
            target: '#AjaxForm_{$name}',
            beforeSubmit: function(data, form, options){
                $('#{$name} [type=submit]').prop("disabled", true).html('{$loading}');
            }
	});
    });
})(jQuery);
JS;
        Requirements::customScript($js, 'BootstrapAjaxForm_Js_'.$this->FormName());
        
        if (!Director::is_ajax()) {
            $this->setTemplate('BootstrapAjaxForm');
        }
    }

    /**
     * Return a rendered version of this form, suitable for ajax post-back.
     * It triggers slightly different behaviour, such as disabling the rewriting of # links
     */
    public function forAjaxTemplate()
    {
        $view = new SSViewer(array(
            $this->getTemplate(),
            'Form'
        ));
                
        $return = $view->dontRewriteHashlinks()->process($this);
                
        // Now that we're rendered, clear message
        $this->clearMessage();

        return $return;
    }
        
    public function AjaxReturn($request)
    {
        if (!Director::is_ajax()) {
            return $this;
        } else {
            if ($this->examineFormAction($request)) {
                return $this;
            } else {
                return $this->forAjaxTemplate();
            }
        }
    }
        
    protected function examineFormAction($request)
    {
        // Determine the action button clicked
        $actionSet = false;
        foreach ($request->requestVars() as $paramName => $paramVal) {
            if (substr($paramName, 0, 7) == 'action_') {
                $actionSet = true;
                break;
            }
        }
        return $actionSet;
    }
}
