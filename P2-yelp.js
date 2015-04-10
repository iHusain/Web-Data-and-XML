var mapBounds = null;
var map = null;
function initialize () {
	console.info('init called');
   var mapCanvas = document.getElementById('map-canvas');
   var mapOptions = {
    	center: new google.maps.LatLng(32.75, -97.13),
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        }
   map = new google.maps.Map(mapCanvas, mapOptions);
   console.info('stuff ', google);
   google.maps.event.addListener(map, 'bounds_changed', getMapBounds);
   getMapBounds();
}
window.addEventListener('load', initialize);
function getMapBounds() {
   	var bounds = map.getBounds();
    console.info('map bounds are: ', map.getBounds());
	var NE = bounds.getNorthEast();
	var SW = bounds.getSouthWest();
	var swLat = SW.lat();
	var swLong = SW.lng();
	var nelat = NE.lat();
	var neLong = NE.lng();
	mapBounds = swLat+","+swLong+"|"+nelat+","+neLong;
}
function sendRequest () {
   var xhr = new XMLHttpRequest();
   var query = encodeURI(document.getElementById("search").value);
   xhr.open("GET", "proxy.php?term="+query+"&bounds="+mapBounds+"&limit=10");
   xhr.setRequestHeader("Accept","application/json");
   xhr.onreadystatechange = function () {
       if (this.readyState == 4) {
          var json = JSON.parse(this.responseText);
          var str = JSON.stringify(json,undefined,2);
          var rest_name,snippet_text;
          var restaurants = new Array();
          var rest_list = document.getElementById('output');
          var latLong = [[],[]];
          clearNode(rest_list);
          for(var i=0; i<json.businesses.length;i++) {
          	var line = json.businesses[i];
          	var rest_name = line.name;
          	var snippet_text = line.snippet_text;
          	var link = document.createElement('a');
          	latLong[0][i] = line.location.coordinate.latitude;
          	latLong[1][i] = line.location.coordinate.longitude;
          	link.appendChild(document.createTextNode(rest_name));
          	var listItem = document.createElement('li');
          	if(line.image_url !== null) {
	          var img = document.createElement('img');
	          var rating_img = document.createElement('img');
    	      img.src = line.image_url;
    	      rating_img.src = line.rating_img_url;
	          listItem.appendChild(img);
	          listItem.appendChild(document.createElement('br'));
	          listItem.appendChild(rating_img);
	          listItem.appendChild(document.createElement('br'));
    	  	}
          	listItem.appendChild(link);
          	listItem.appendChild(document.createElement('br'));
          	listItem.appendChild(document.createTextNode(snippet_text));
          	listItem.appendChild(document.createElement('br'));
          	listItem.appendChild(document.createElement('br'));
          	link.addEventListener('click',setOnClick(link,line.url), false);		
          	rest_list.appendChild(listItem);
          }
          console.log(latLong);
          setMarkers(latLong,map);
       }
   };
   xhr.send(null);
}
function setOnClick(link,url) {
	return function() {
    		link.href = url;
	}
}

function setMarkers(location,map){

    for (i = 0; i < 10; i++) {
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(location[0][i],location[1][i]),
		map: map
		});
	//extend the bounds to include each marker's position
	}
}
function clearNode(node) {
	while(node.firstChild) {
		node.removeChild(node.firstChild);
	}
}
