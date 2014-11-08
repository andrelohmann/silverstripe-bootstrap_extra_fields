<?php
/**
 * @author Andre Lohmann
 * 
 * @package geoform
 * @subpackage fields-formattedinput
 */
class BootstrapLocationField extends LocationField {
	
	/**
	 * @param string $name - Name of field
	 * @return FormField
	 */
	protected function FieldLatitude($name) {
		
		$field = new TextField("{$name}[Latitude]");
		
		return $field;
	}
	
	/**
	 * @param string $name - Name of field
	 * @return FormField
	 */
	protected function FieldLongditude($name) {
		
		$field = new TextField("{$name}[Longditude]");
		
		return $field;
	}
	
	public function Field($properties = array()) {
		$name = $this->getName();
                $this->fieldLatitude->setPlaceholder(_t('GeoForm.FIELDLABELLATITUDE', 'Latitude'));
                $this->fieldLongditude->setPlaceholder(_t('GeoForm.FIELDLABELLONGDITUDE', 'Longditude'));
                
                return '<div class="row">'.
                             '<div class="col-md-6">'.
                             $this->fieldLatitude->Field().
                             '</div>'.
                             '<div class="col-md-6">'.
                             $this->fieldLongditude->Field().
                             '</div>'.
                             '</div>';
	}
}