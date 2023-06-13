$(document).ready(function(){

        
       //console.log(site_url);
       var lat=long='';
       

		if (navigator.geolocation) {
            const options = {
          enableHighAccuracy: true,
          timeout: 5000,
          maximumAge: 0,
        };

        function success(pos) {
          const crd = pos.coords;
          lat  = crd.latitude;
          long = crd.longitude;
          //console.log("Your current position is:");
          //console.log(`Latitude : ${crd.latitude}`);
          //console.log(`Longitude: ${crd.longitude}`);
          //console.log(`More or less ${crd.accuracy} meters.`);
          //console.log('before',lat+" <> "+long);

          jQuery.ajax({

            type: "POST",
            url: site_url+"/wp-admin/admin-ajax.php",
            data: {

                action     : "get_user_location",
                lat        :  lat,
                long       :  long,
                
            },
            //dataType    : "json",
            //encode      : true,
            success: function (data) { 

                    //console.log(data);
                    $("#show_data").html(data);
                    //console.log("the end");
           }
          });
        }

        function error(err) {
          console.warn(`ERROR(${err.code}): ${err.message}`);
        }

        navigator.geolocation.getCurrentPosition(success, error, options);
            
		} else {
		    alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
		}
        
    });
