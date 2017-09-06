$(document).ready(function(){


  var directionsService ;

  var directionsDisplay;
  var infos;
   
   
  
  function init(){
  



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
    
        

          }


  // modal Map
  function init2(){
    



        map2 = new google.maps.Map(document.getElementById('map2'), {
            zoom: 16,
            center: new google.maps.LatLng(31.675905,-8.0473),
        });
       
        

          directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();
        
          /*connexion de la map + le panneau de l'itinéraire*/
            directionsDisplay.setMap(map2);
          

        
        

                    }


     function all()
     {
        $.ajax({
    type:"POST",
    url:"all/acceuil",
    dataType: 'json',
    
    success:function(data) {
       getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});
     }
  
  window.initMap = function() {
    
    init() ; 
  all() ; 
    init2() ;
  }


   function handleLocationError(browserHasGeolocation, infoWindow, pos) {
          infoWindow.setPosition(pos);
          infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
        }


       
            function getMarkers(response)
    

{
                      
        var infoWindow = new google.maps.InfoWindow;
      var infowincontent = new Array();
      var marker = new Array();
            var k;
                
            var tt= Array() ;
      var tab=new Array() ; 
            // pour recuperer tous les id_entreprise 
            for (var i = 0; i < response.length; i++) 
            {
                 tab[i]= response[i].entreprise_id_entreprise ; 

                
            }
                           $.ajax({
                            type:"POST",
                             data:({id:tab}),
                             url:"getInfo/acceuil",
                             dataType: 'json',
    
                           success:function(d) {
                            
            for (var i = 0; i < response.length; i++) {
                    
                    var lat = response[i].altitude;
                    var lng = response[i].longitude;
                    var name =response[i].nom;
                    console.log(name) ; 
                    var latLng = new google.maps.LatLng(lat,lng);
                 //var adress=response[i].adresse                               
           
/*

                    var text = document.createElement('text');
                    text.textContent = adress
                    infowincontent[i].appendChild(text);
*/
    
                    var icon="P";
                    //Les info affichées en cliquent sur le mark
                    infowincontent[i] = document.createElement('div');
                    infowincontent[i].style.height = "250px" ;
                        infowincontent[i].style.overflow = "hidden" ;

                    var img = document.createElement("IMG");
                     img.src = "../../GeoEntreprise/public/img/"+d[i].image;
                     img.style.width = "350px";
                       img.style.height = "140px";
                    var strong = document.createElement('strong');
                   
                     var text = document.createElement('text');
                  
                       
                           strong.textContent =d[i].nom+" ,"+name;
 tt[i]="<tr><td>Dénomination</td><td>"+d[i].denomination+"</td></tr><tr><td>Adresse</td><td>"+d[i].adresse+"</td></tr><tr><td>SIREN</td><td>"+d[i].siren+"</td></tr>"+
 +"<tr><td>Ville</td><td>"+d[i].ville+"</td></tr><tr><td>Capital social</td><td>"+d[i].capital_social+"</td></tr><tr><td>Forme juridique</td><td>"+d[i].forme_juridique+"</td></tr>"+ 
    +"<tr><td>Date de création</td><td>"+d[i].date_creation+"</td></tr><tr><td>Rayonnement</td><td>"+d[i].rayonnement+"</td></tr><tr><td>Chiffre d'affaire</td><td>"+d[i].CA+"</td></tr>" ;                
                           infowincontent[i].appendChild(img);
                           infowincontent[i].appendChild(document.createElement('br'));
                            infowincontent[i].appendChild(document.createElement('br'));

                        infowincontent[i].appendChild(strong);
                        
                        infowincontent[i].appendChild(document.createElement('br'));
                        infowincontent[i].appendChild(document.createElement('br'));                      
                        
                         var img2 = document.createElement("IMG");
                     img2.src = "../../GeoEntreprise/public/img/localiser.jpg";
                     img2.style.width = "20px";
                       img2.style.height = "20px";
                    text.textContent = d[0].adresse  ;
                    infowincontent[i].appendChild(img2);
                    infowincontent[i].appendChild(text);
                   infowincontent[i].appendChild(document.createElement('br'));
                   infowincontent[i].appendChild(document.createElement('br'));

                    var btn = document.createElement("BUTTON");
                   // btn.setAttribute("id", "btn_id"); 
                   // $("#btn_id").attr("data-toggle", "modal");
                     //$("#btn_id").attr("data-target", "#myModal");
                     btn.addEventListener("click", function(){
                         
                           // initmap(lng,lat) ; 
                              
                           //init2() ;
                            map2 = new google.maps.Map(document.getElementById('map2'), {
                                zoom: 16,
                              center: new google.maps.LatLng(response[m].altitude,response[m].longitude),
                                  });
                           marker2 = new google.maps.Marker({
                        position:new google.maps.LatLng(response[m].altitude,response[m].longitude),
                        map: map2,
                        //label:'P',
                        icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        
                    });
                      
         

                

                      $("#tab").html(tt[m]);
                       


                      $('#myModal').modal('show'); 
                      




                  }); 


                           // Create a <button> element
                     var t = document.createTextNode("Visualiser la fiche");
                       //t.style.color="#0000FF"  ;
                       
                       btn.setAttribute("STYLE","color:white");
                        btn.style.backgroundColor = "#1E90FF";
                        btn.style.borderColor = "#1E90FF";
                         btn.style.borderRadius = "4px";
                  // Create a text node
                       btn.appendChild(t); 
                       infowincontent[i].appendChild(btn);


                    // create Markers   
                    marker[i] = new google.maps.Marker({
                        position:latLng,
                        map: map,
                        //label:'P',
                        icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        idMap:i
                    });
                     marker[i].addListener('click', function() {
                            infoWindow.setContent(infowincontent[this.idMap]);
                            infoWindow.open(map, this);
                            m= this.idMap; 
                            
                          });
                     
                             
                    
                } 
                                    },
                              error:function() {
                               alert("Aucune Entreprise!");
                                    }
                                });



        
            } 





$('.s').on('change', function () {
     var i=$('#id_entreprise').val()  ; 
     var j=$('#domaine_id_domaine').val()  ; 
     var k=$('#libelle').val(); 

  if(i=="all" && j=="all" && k=="all")  // sans filtre
         {
    init()  ;
    all() ; 

         }
         else{
          if(i=="all" && j!="all" && k=="all"){ // par domaine
      $.ajax({
    type:"POST",
     data:({id:j}),
    url:"search_by_domaine/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});
 } 

   if(i=="all" && j=="all" && k!="all")  // par departement
   {
         $.ajax({
    type:"POST",
     data:({id:k}),
    url:"search_by_depart/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});
   }

   if(j=="all" && i!="all" && k=="all") // par entreprise
   {

  $.ajax({
    type:"POST",
     data:({id:i}),
    url:"search_by_entreprise/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});


   }

if(i!="all" && j!="all" && k=="all") // par domaine et entrprise
{
   
     $.ajax({
    type:"POST",
     data:({id:i, id2:j}),
    url:"search_domaine_entreprise/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});


}

if(i=="all" && j!="all" && k!="all") // par domaine et departement
{
   
     $.ajax({
    type:"POST",
     data:({id:j, id2:k}),
    url:"search_depart_domaine/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});


}
if(i!="all" && j=="all" && k!="all") // par entreprise et departement
{
   
     $.ajax({
    type:"POST",
     data:({id:i, id2:k}),
    url:"search_depart_entreprise/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});


}
if(i!="all" && j!="all" && k!="all") // par entreprise et departement et domaine
{
   
     $.ajax({
    type:"POST",
     data:({id:i, id2:j , id3:k}),
    url:"search_by_all/acceuil",
    dataType: 'json',
    
    success:function(data) {
      init() ; 
     getMarkers(data) ; 
    },
    error:function() {
        alert("error!");
    }
});


}


}
      
});


        });
                
   
