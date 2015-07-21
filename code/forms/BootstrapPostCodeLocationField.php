<?php
/**
 * @author Andre Lohmann
 * 
 * @package geoform
 * @subpackage fields-formattedinput
 */
class BootstrapPostCodeLocationField extends PostCodeLocationField {
	
	/**
	 * @param string $name - Name of field
	 * @return FormField
	 */
	protected function FieldPostcode($name) {
		
		$field = new TextField("{$name}[Postcode]");
		
		return $field;
	}
	
	/**
	 * @param string $name - Name of field
	 * @return FormField
	 */
	protected function FieldCountry($name) {
		
		$field = new TextField("{$name}[Country]");
		
		return $field;
	}
	
	public function Field($properties = array()) {
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.min.js');
                
                if(GoogleMaps::getApiKey()) Requirements::javascript('//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&language='.i18n::get_tinymce_lang().'&key='.GoogleMaps::getApiKey());  // don't use Sensor on this Field
                else  Requirements::javascript('//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&language='.i18n::get_tinymce_lang());
                
                $name = $this->getName();
                $this->fieldPostcode->setPlaceholder(_t('PostCodeLocationField.ZIPCODEPLACEHOLDER', 'ZIP/Postcode'));
                $this->fieldCountry->setPlaceholder(_t('PostCodeLocationField.CITYCOUNTRYPLACEHOLDER', 'City/Country'));
		
		// set caption if required
		$js = <<<JS
jQuery(document).ready(function() {
    // bind PostCodeLocationChanged to Postcode and Country Fields
    jQuery('#{$name}-Postcode').keyup({$name}PostCodeLocationChanged);
    jQuery('#{$name}-Country').keyup({$name}PostCodeLocationChanged);
});

var {$name}PostcodeTypeTimer = null;

// react on typing
function {$name}PostCodeLocationChanged(){
    // check typeTimer and delete
    if({$name}PostcodeTypeTimer){
        clearTimeout({$name}PostcodeTypeTimer);
    }
                        
    // trim Postcode value
    var postcode = jQuery('#{$name}-Postcode').val().replace(/\s+$/,"").replace(/^\s+/,"");
    // trim Country value
    var country = jQuery('#{$name}-Country').val().replace(/\s+$/,"").replace(/^\s+/,"");
    
    // Postcode or Country at least more than 2 digits and not placeholster is stristr of value
    if(postcode.length >= 2 || country.length >= 2){
        {$name}PostcodeTypeTimer = setTimeout('{$name}PostCodeLocationFetch()', 500); // execute googlemaps request after 1/2 second of not typing
    }
}

var {$name}PostcodeGeocoder = null;

// fetch google data and update lat, lng
function {$name}PostCodeLocationFetch(){
    // clear Lat + Lng
    jQuery('#{$name}-Latitude').val('');
    jQuery('#{$name}-Longditude').val('');
    
    // trim Postcode value
    var postcode = jQuery('#{$name}-Postcode').val().replace(/\s+$/,"").replace(/^\s+/,"");
    // trim Country value
    var country = jQuery('#{$name}-Country').val().replace(/\s+$/,"").replace(/^\s+/,"");
    
    // create request
    var Request = {
        address: postcode+', '+country
    };
    
    // create geocoder
    {$name}PostcodeGeocoder = new google.maps.Geocoder();
    {$name}PostcodeGeocoder.geocode(Request, {$name}PostcodeGeocoderCallback);
}

function {$name}PostcodeGeocoderCallback(Response, Status){
    // Status OK
    if(Status == 'OK'){
        if(Response.length == 1){
            jQuery('#{$name}-Latitude').val(Response[0]['geometry']['location'].lat());
            jQuery('#{$name}-Longditude').val(Response[0]['geometry']['location'].lng());
            //alert($('#{$name}-Latitude').val()+','+$('#{$name}-Longditude').val());
        }else{
            // check if there is only one locality, while all others are places of interest
            var id = PostcodeIsSingleLocality(Response);
            if(id != null){
                jQuery('#{$name}-Latitude').val(Response[id]['geometry']['location'].lat());
                jQuery('#{$name}-Longditude').val(Response[id]['geometry']['location'].lng());
            }
        }
    }
}

function PostcodeIsSingleLocality(Response){
    // check if Response has only one locality->Political
    var counter = 0;
    var locality = null;
    for(var i=0; i<Response.length; i++){
        // check if type is locality political
        if(Response[i]['types'][0] == 'locality' && Response[i]['types'][1] == 'political'){
            locality = i;
            counter++;
        }
    }
    
    return (counter == 1) ? locality : null;
}
JS;
		Requirements::customScript($js, 'BootstrapPostCodeLocationField_Css_'.$this->ID());
                
                return $this->fieldLatitude->Field().
                             $this->fieldLongditude->Field().
                             '<div class="row">'.
                             '<div class="col-sm-6">'.
                             $this->fieldPostcode->Field().
                             '</div>'.
                             '<div class="col-sm-6">'.
                             $this->fieldCountry->Field().
                             '</div>'.
                             '</div>';
	}
}