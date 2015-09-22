<?php
/**
 * @author Andre Lohmann
 * 
 * @package geoform
 * @subpackage fields-formattedinput
 */
class BootstrapGeoLocationField extends GeoLocationField {
	
	/**
	 * @param string $name - Name of field
	 * @return FormField
	 */
	protected function FieldAddress($name) {
		
		$field = new TextField("{$name}[Address]");
		
		return $field;
	}
	
	public function Field($properties = array()) {
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
		Requirements::javascript('geoform/javascript/jquery.geocomplete.js');
                
		if(GoogleMaps::getApiKey()) Requirements::javascript('//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&language='.i18n::get_tinymce_lang().'&key='.GoogleMaps::getApiKey());  // don't use Sensor on this Field
		else  Requirements::javascript('//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&language='.i18n::get_tinymce_lang());

		$name = $this->getName();
		$this->fieldAddress->setPlaceholder(_t('GeoLocationField.ADDRESSPLACEHOLDER', 'Address'));
		
		// set caption if required
		$js = <<<JS
(function($){
    $(function(){
		$("#{$name}_Address").change(function(){
			$("#{$name}_Latitude").val('');
            $("#{$name}_Longditude").val('');
		});
        $("#{$name}_Address").geocomplete().bind("geocode:result", function(event, result){
            $("#{$name}_Latitude").val(result.geometry.location.lat());
            $("#{$name}_Longditude").val(result.geometry.location.lng());
        });
    });
})(jQuery);
JS;
		Requirements::customScript($js, 'BootstrapGeoLocationField_Js_'.$this->ID());

		$css = <<<CSS
/* make the location suggest dropdown appear above dialog */
.pac-container {
    z-index: 2000 !important;
}
CSS;
		Requirements::customCSS($css, 'BootstrapGeoLocationField_Css_'.$this->ID());

		return $this->fieldLatitude->Field().
				$this->fieldLongditude->Field().
				'<div class="row">'.
				'<div class="col-sm-12">'.
				$this->fieldAddress->Field().
				'</div>'.
				'</div>';
	}
}