  var glob_autocomplete;
  var glob_map;
  var glob_master_marker;
  var glob_map_container = "#draggable_map";


  var glob_component_form = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'long_name',
      postal_code: 'short_name'
  };

  var glob_options = {};
  glob_options.types = ['address'];



  $(document).ready(function()
  {
    $('#btn_add').click(function()
    {
        if($('#validation-form').parsley().validate()==false) return;
        $.ajax({
                    
            url: module_url_path+'/save',
            data: new FormData($('#validation-form')[0]),
            contentType:false,
            processData:false,
            method:'POST',
            cache: false,
            dataType:'json',
            beforeSend: function () {
              showProcessingOverlay();
            },
            success:function(data)
            {
                if('success' == data.status)
                {
                  hideProcessingOverlay();                   
                  $('#validation-form')[0].reset();

                    swal({
                           title: data.status,
                           text: data.description,
                           type: data.status,
                           confirmButtonText: "OK",
                           closeOnConfirm: false
                        },
                       function(isConfirm,tmp)
                       {
                         if(isConfirm==true)
                         {  
                            window.location.href = data.link;
                         }
                       });
                }
                else
                {
                   swal('warning',data.description,data.status);
                }  
            }
            
        });   

    });

  });


  function changeCountryRestriction(ref)
  {
     var country_code = $(ref).val();
     destroyPlaceChangeListener(autocomplete);
     // load states function
     // loadStates(country_code);  
   
     glob_options.componentRestrictions = {country: country_code}; 
   
     initAutocomplete(country_code);
   
     glob_autocomplete = false;
     glob_autocomplete = initGoogleAutoComponent($('#autocomplete')[0],glob_options,glob_autocomplete);
  }
   
 function initAutocomplete(country_code) 
 {
      // country_code = country_code || "RU";

      glob_options.componentRestrictions = {
          country: country_code
      };

      glob_autocomplete = false;
      glob_autocomplete = initGoogleAutoComponent($('#autocomplete')[0], glob_options, glob_autocomplete);

      initGoogleMap();

      var preset_latlng = new google.maps.LatLng( $('#lat').val().trim(), $('#lng').val().trim());


      placeMarkerAndPanTo(preset_latlng,glob_map);
  }


 function initGoogleAutoComponent(elem, options, autocomplete_ref) 
 {
      autocomplete_ref = new google.maps.places.Autocomplete(elem, options);
      autocomplete_ref = createPlaceChangeListener(autocomplete_ref, fillInAddress);

      return autocomplete_ref;
  }

  function initGoogleMap()
  {
    if($(glob_map_container).length > 0)
    {
      var mapOptions = {
        zoom: 12,
        center: {lat: -34.397, lng: 150.644},
      };

      /* Initialize Map */
      glob_map = new google.maps.Map(document.getElementById('draggable_map'),mapOptions);

      /* Initialize Marker */
      glob_master_marker = new google.maps.Marker({position: {lat: -34.397, lng: 150.644}, map: glob_map,draggable:true});

      var geocoder = new google.maps.Geocoder;
      var infowindow = new google.maps.InfoWindow


      /* Add Listener to Marker */
      glob_master_marker.addListener('dragend', function(e) {
       placeMarkerAndPanTo(e.latLng, glob_map);
        geocodeLatLng(geocoder, glob_map, infowindow);

      });

      /* Add Listener to Map */
      glob_map.addListener('click', function(e) {
       placeMarkerAndPanTo(e.latLng, glob_map);
        geocodeLatLng(geocoder, glob_map, infowindow);

      });
  

    }
  }

   function geocodeLatLng(geocoder, glob_map, infowindow)
   {
     
        var lat = $('#lat').val();
        var lng = $('#lng').val();

        var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
        
        geocoder.geocode({'location': latlng}, function(results, status) {
          
          if (status === 'OK') {
            if (results[0]) {
              glob_map.setZoom(12);
             
             infowindow.setContent(results[0].formatted_address);

             infowindow.open(glob_map, glob_master_marker);

            $('#autocomplete').val(results[0].formatted_address);

            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }


  function placeMarkerAndPanTo(latLng, map) {
    map.panTo(latLng);

    glob_master_marker.setPosition(latLng);
    $('#lat').val(latLng.lat());
    $('#lng').val(latLng.lng());
  }  

  function createPlaceChangeListener(autocomplete_ref, fillInAddress) {
      autocomplete_ref.addListener('place_changed', fillInAddress);
      return autocomplete_ref;
  }

  function destroyPlaceChangeListener(autocomplete_ref) {
      google.maps.event.clearInstanceListeners(autocomplete_ref);
  }

  function fillInAddress() 
  {
    // Get the place details from the autocomplete object.
    var place = glob_autocomplete.getPlace();


      // $('#lat').val(place.geometry.location.lat());
      // $('#lng').val(place.geometry.location.lng());
    if(place.geometry != undefined)
    {
      placeMarkerAndPanTo(place.geometry.location,glob_map);

      for (var component in glob_component_form) {
          $("#" + component).val("");
          $("#" + component).attr('disabled', false);
      }

      if (place.address_components.length > 0) {
          $.each(place.address_components, function(index, elem) {
              var addressType = elem.types[0];
              if (glob_component_form[addressType]) {
                  var val = elem[glob_component_form[addressType]];
                  $("#" + addressType).val(val);
              }
          });
      }
    }

  }