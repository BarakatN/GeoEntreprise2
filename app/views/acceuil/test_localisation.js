$(document).ready(function(){


	var directionsService ;

	var directionsDisplay;
	
	 var t="" ; 
	
	function init(){
	
 t="coucou" ; 
    document.getElementById('test').innerHTML=t;

		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
			center: new google.maps.LatLng(31.675905,-8.0473),
		});
		var infoWindowo = new google.maps.InfoWindow({map: map});
		

		  directionsService = new google.maps.DirectionsService();
		    directionsDisplay = new google.maps.DirectionsRenderer();
		
		  /*connexion de la map + le panneau de l'itinéraire*/
		    directionsDisplay.setMap(map);
		  geocoder = new google.maps.Geocoder();
		

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
             pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
             
             
            mapos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
 
            infoWindowo.setPosition(pos);
            infoWindowo.setContent('My location');
            //map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindowo, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindowo, map.getCenter());
        }
		
        // add markers (calling function getData())
        var latLng = new google.maps.LatLng(31.669837,-8.042872);

     //Les info affichées en cliquent sur le mark
     var infoWindow = new google.maps.InfoWindow;
					infowincontent = document.createElement('div');
					var strong = document.createElement('strong');
					strong.textContent ="Pharmacie Hay Sinai";
					infowincontent.appendChild(strong);
					infowincontent.appendChild(document.createElement('br'));

					var text = document.createElement('text');
					text.textContent = "Marrakech Maroc"  ; 
					infowincontent.appendChild(text);

		  	 marker = new google.maps.Marker({
						position:latLng,
						map: map,
						//label:'P',
						//icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
						
					});
					 marker.addListener('click', function() {
			                infoWindow.setContent(infowincontent);
			                infoWindow.open(map, this);
			              });

     //getData() ; 

              
	}
	
	window.initMap = function() {
		
		init() ; 
	}
	 function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	        infoWindow.setPosition(pos);
	        infoWindow.setContent(browserHasGeolocation ?
	                              'Error: The Geolocation service failed.' :
	                              'Error: Your browser doesn\'t support geolocation.');
	      }


	     

          $("#d").click(function(event){
  
 
                              $.ajax({
                   url: 'http://localhost/GeoEntreprise/acceuil/ConnectDB',
                   
                              })
                .done(function(data) {
     


     // var tt= JSON.stringify(data) ;
    //  var obj = JSON.parse(tt);
        var obj = JSON.parse(data); 
        //var tt= data.toString()  ; 
         
        document.getElementById('test').innerHTML="the result is --->"+obj[0].nom; 
          
            


})
.fail(function() {
  alert("Ajax failed to fetch data")
})
/*

             $.ajax({
  url: 'http://localhost/GeoEntreprise/acceuil/ConnectDB',
    dataType: 'application/json',
    complete: function(data){
             //var res=data.toString().substring(1,data.length) ; 

           var tt=jQuery.parseJSON(data) ;
       document.getElementById('test').innerHTML=tt; 
    },
    success: function(data){
      document.getElementById('test').innerHTML=tt ; 
    }

});
*/
  // var url="http://localhost/GeoEntreprise/acceuil/ConnectDB" ; 
 




                                })
        });
                
   
