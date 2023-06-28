{{-- 
@php

if(isset($site_setting_arr['site_logo']) && $site_setting_arr['site_logo']!='' && file_exists($site_setting_arr['site_logo']))
{
    $path = url('/').'/uploads/profile_image/'.$site_setting_arr['site_logo'];
}
else
{
    $path = url('/').'/assets/front/images/chow-logo.png';
}


 
$site_logo = url('/')."/assets/front/images/chow-logo.png";    
       

@endphp
<body style="background-color: #fff;">
<style type="text/css">
 .data_container {
  width: 200px;
  word-wrap: break-word;
}

.data_container2 {
  word-wrap: break-word;

}
</style>
<div style="margin:0 auto; width:100%;">
<table width="100%" bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ddd;font-family:Arial, Helvetica, sans-serif;">
    <tr>
        <td colspan="2" style="padding: 10px 18px;">
            <table bgcolor="#fff" width="100%" border="0" cellspacing="10" cellpadding="0">
                <tr>
                    <td width="40%" style="font-size:40px; color: #fff;"> <img src="{{$site_logo or ''}}" width="150px" alt=""/></td>
                    <td width="60%" style="text-align:right; color: #333;">
                        <h3 style="line-height:25px;margin:0px;padding:0px;">Chow420</h3>
                       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
   
    <tr>
        <td colspan="2" style="background-color: #d3d7de;padding:10px 10px 10px 30px;font-size:12px;">
           
            
            <table width="100%">
                <tr>
                    <td width="50%">
                         <h3 style="font-size:18px;padding:0;margin:0px;">Order ID: 576575 </h3>
                    </td>
                    <td width="50%" style="background-color: #d3d7de;padding:10px;font-size:16px; text-align: right;">
                       <b>Order Date:</b> {{us_date_format(date("Y/m/d"))}}
                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
    <tr>
        <td colspan="2" style="height:10px;">
            &nbsp;
        </td>
    </tr>
    <tr>

        <td colspan="2" style="padding:10px 30px 10px 30px; font-size:12px;">
            <table width="100%">
             <tbody>
               
                <tr>
                    <td colspan="3">
                        <table width="100%">
                             <td width="50%" style="font-size:12px;"> <h3 style="margin-bottom: 5px;">Shipping Address</h3>
                            <div class="data_container">
                                {{isset($address['shipping'])?$address['shipping']:'N/A'}}{{isset($address['shipping_city'])?", ".$address['shipping_city']:''}}{{isset($address['shipping_state'])?", ".$address['shipping_state']:''}}{{isset($address['shipping_country'])?", ".$address['shipping_country']:''}}{{isset($address['shipping_zipcode'])?" - ".$address['shipping_zipcode']:''}}.
                            </div>
                           </td>

                       
                        </table>
                       
                    </td>
                   
                </tr>
               

             </tbody>
            </table>
        </td>
    </tr>

   
    
     <tr>

        <td colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">S.No.</th>
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Product Name</th>
               
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Unit Price</th>

                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Qty.</th>
                     
                    <th style=" background-color: #eeeff1;font-size:14px;font-weight: bold;text-align: left;border-top:1px solid #d3d7dd; padding:12px 12px 12px 30px;border-bottom: 1px solid #d3d7dd;">Total</th>
                </tr>
               
          {{--  @foreach($order as $key => $ord) --}}
                

               {{--  <tr>
                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">1</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>test</td>                       

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$100</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$10</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$5</td>
 
                 </tr>

                  <tr>
                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">1</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>test</td>                       

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$100</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$10</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$5</td>
                 </tr>

                  <tr>
                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">1</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;"><b>test</td>                       

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$100</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$10</td>

                    <td style="border-bottom: 1px solid #e5e9f1;font-size:12px;text-align: left;padding:12px 12px 12px 30px;">$5</td>
                 </tr>


               
            </table>
        </td>
    </tr>
<tr>
    <td colspan="2" style="background-color: #eeeff1" height="10px"></td>
</tr>
    <tr> 
        <td width="80%" style="text-align: right; font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Subtotal
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            $121
        </td>
    </tr>
    <tr>
        <td width="80%" style="text-align: right; font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Shipping Charges
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            $457
        </td>
    </tr>
    <tr>
        <td width="80%" style="text-align: right;font-size:13px; font-weight: bold; border-right:1px solid #e5e9f1;border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            Total
        </td>
        <td width="20%" style="text-align: center; font-size:13px; font-weight: bold; border-bottom:1px solid #e5e9f1; padding:12px; text-transform: uppercase; color: #000;">
            $45
        </td>
    </tr>
     
  <tr>
    <td colspan="2" style="background-color: #eeeff1" height="10px"></td>
</tr>
    <tr>
        <td colspan="2" style="padding: 20px 20px 5px; color: #fff; background-color: #873dc8; text-align: center;"> If you have any questions about this invoice, please contact
        </td>
    </tr>
    <tr>
       
    </tr>
    <tr>
        <td colspan="2" style="padding: 5px 10px 20px; color: #fff; text-align: center; font-size: 20px; background-color: #873dc8;">
           <b>Thank You For Your Business!</b>
        </td>
    </tr>



</table>
</div>
</body>
 --}} 


 <!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete Address Form</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #locationField,
      #controls {
        position: relative;
        width: 480px;
      }

      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }

      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
        font-family: "Roboto", Arial, Helvetica, sans-serif;
      }

      #address {
        border: 1px solid #000090;
        background-color: #f0f9ff;
        width: 480px;
        padding-right: 2px;
      }

      #address td {
        font-size: 10pt;
      }

      .field {
        width: 99%;
      }

      .slimField {
        width: 80px;
      }

      .wideField {
        width: 200px;
      }

      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
    </style>
    <script>
      // This sample uses the Autocomplete widget to help the user select a
      // place, then it retrieves the address components associated with that
      // place, and then it populates the form fields with those details.
      // This sample requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script
      // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      let placeSearch;
      let autocomplete;
      const componentForm = {
        street_number: "short_name",
        route: "long_name",
        locality: "long_name",
        administrative_area_level_1: "short_name",
        country: "long_name",
        postal_code: "short_name",
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
          document.getElementById("autocomplete"),
          { types: ["geocode"] }
        );
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(["address_component"]);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();

        for (const component in componentForm) {
          document.getElementById(component).value = "";
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (const component of place.address_components) {
          const addressType = component.types[0];

          if (componentForm[addressType]) {
            const val = component[componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition((position) => {
            const geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            const circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy,
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
  </head>
  <body>
    <div id="locationField">
      <input
        id="autocomplete"
        placeholder="Enter your address"
        onFocus="geolocate()"
        type="text"
      />
    </div>

    <!-- Note: The address components in this sample are typical. You might need to adjust them for
               the locations relevant to your app. For more information, see
         https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
    -->

    <table id="address">
      <tr>
        <td class="label">Street address</td>
        <td class="slimField">
          <input class="field" id="street_number" disabled="true" />
        </td>
        <td class="wideField" colspan="2">
          <input class="field" id="route" disabled="true" />
        </td>
      </tr>
      <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3">
          <input class="field" id="locality" disabled="true" />
        </td>
      </tr>
      <tr>
        <td class="label">State</td>
        <td class="slimField">
          <input
            class="field"
            id="administrative_area_level_1"
            disabled="true"
          />
        </td>
        <td class="label">Zip code</td>
        <td class="wideField">
          <input class="field" id="postal_code" disabled="true" />
        </td>
      </tr>
      <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3">
          <input class="field" id="country" disabled="true" />
        </td>
      </tr>
    </table>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwEKBOzIn5iOO4_0VuFcCldDziZn0cYbc&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
  </body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{-- 

<script>
     $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done(function(location) {
        console.log(location);
        alert(location.city);alert(location.country_code);alert(location.state);
        alert(location.postal);
       // alert(location.latitude);
      //  alert(location.longitude);
       // alert(location.IPv4);   
        
        var country  = location.country_name;
        var state = location.state;

        
                  
     });
</script>
 --}}