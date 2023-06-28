  var glob_default_country_code = false;
  var glob_autocomplete;
  var glob_component_form = 
  {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name', 
    administrative_area_level_2: 'long_name', 
    sublocality_level_1: 'long_name', 
    postal_code: 'short_name'
  };

  function handlerchangeCountryRestriction(obj,ref)
  {    
     
    if(ref=='selected')
    {
      var isoCode  = $(obj).find("option:selected").attr('data-iso');             
    }
    if(ref=='all')
    {
      var isoCode  = obj;  
    }

    changeCountryRestriction(isoCode);
  }
  function changeCountryRestriction(country_code)
  {

    var temp = country_code;
    // var temp = '';
    // temp = country_code.split(',');
   
    destroyPlaceChangeListener(address);
    glob_options.componentRestrictions = {country: temp}; 
    glob_autocomplete = false;
    glob_autocomplete = initGoogleAutoComponent($('#address')[0],glob_options,glob_autocomplete);
  }
  function initAutocomplete() 
  {
    //$("#country").trigger('change');
    $('select[name=country] option:selected').trigger('change');
  }

  function initGoogleAutoComponent(elem,options,autocomplete_ref)
  {
    autocomplete_ref = new google.maps.places.Autocomplete(elem,options);
    autocomplete_ref = createPlaceChangeListener(autocomplete_ref,fillInAddress);
    return autocomplete_ref;
  }
  
  function createPlaceChangeListener(autocomplete_ref,fillInAddress)
  {
    autocomplete_ref.addListener('place_changed', fillInAddress);
    return autocomplete_ref;
  }

  function destroyPlaceChangeListener(autocomplete_ref)
  {
    google.maps.event.clearInstanceListeners(autocomplete_ref);
  }

  function key_exists(key, search) {
    if (!search || (search.constructor !== Array && search.constructor !== Object)) {
        return false;
    }
    for (var i = 0; i < search.length; i++) {
        if (search[i] === key) {
            return true;
        }
    }
    return key in search;
  }
  function fillInAddress() 
  {
    /* Get the place details from the autocomplete object.*/
    var place = glob_autocomplete.getPlace();
    var isValid = key_exists('place_id', place); /*true*/
    if(isValid == true)
    {
      //FindLocaiton(place.formatted_address);
      $('#lat').val(place.geometry.location.lat());
      $('#lng').val(place.geometry.location.lng());     

      for (var component in glob_component_form) 
      {
        $("#"+component).val("");
        $("#"+component).attr('readonly',true);
      }

      if(place.address_components.length > 0 )
      {
        $.each(place.address_components,function(index,elem)
        {
            var addressType = elem.types[0];
            // console.log(elem.types[0]);
            if(glob_component_form[addressType])
            {
              var val = elem[glob_component_form[addressType]];
              if(addressType == 'locality')
              {
                $("#city").val(val) ;                                
              }
              if(addressType == 'sublocality_level_1')
              {
                $("#sublocality").val(val) ;                                
              }
              if(addressType == 'administrative_area_level_1')
              {
                $("#state").val(val) ;                                
              }
              if(addressType == 'postal_code')
              {
                $("#post_code").val(val) ;                                
              }

            }
        });  
      }
    }
    else
    {
        $('#address').val('');
    }
    
    $("#err_address").html('');
    return false;
  }