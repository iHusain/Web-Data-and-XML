function initialize () {
}

function sendRequest () {
   var xhr = new XMLHttpRequest();
   var query = encodeURI(document.getElementById("form-input").value);
   xhr.open("GET", "proxy.php?method=/3/search/movie&query=" + query);
   xhr.setRequestHeader("Accept","application/json");
   xhr.onreadystatechange = function () {
       if (this.readyState == 4) {
          var json = JSON.parse(this.responseText);
          var str = JSON.stringify(json,undefined,2);
          
          var movie_title,release_date;
          var movies = new Array();
          var movieList = document.getElementById('movieList');
          clearNode(movieList);
          var movieDesc = document.getElementById('movieDesc');
          clearNode(movieDesc);
          for(var i=0; i<json.results.length;++i) {
          	var line = json.results[i];
          	var movieTitle = line.title;
          	var releaseDate = line.release_date;
          	var link = document.createElement('a');
          	link.appendChild(document.createTextNode(movieTitle));
          	var listItem = document.createElement('li');
          	listItem.appendChild(link);
          	listItem.appendChild(document.createElement('br'));
          	listItem.appendChild(document.createTextNode(releaseDate));
          	movieList.appendChild(listItem);
          	listItem.onclick = getSetDescForId(line.id,line.title);
          }
       }
   };
   xhr.send(null);
}

function getSetDescForId(value,title) {
	return function() {
		setDescription(value,title);
	}
}

function clearNode(node) {
	while(node.firstChild) {
		node.removeChild(node.firstChild);
	}
}

function setDescription(id,title) {
   var movie_title = title;
   var xhr = new XMLHttpRequest();
   xhr.open("GET", "proxy.php?method=/3/movie/"+id);
   xhr.setRequestHeader("Accept","application/json");
   xhr.onreadystatechange = function () {
       if (this.readyState == 4) {
          var json = JSON.parse(this.responseText);
          var str = JSON.stringify(json,undefined,2);
          var movieDesc = document.getElementById('movieDesc');
          clearNode(movieDesc);
          if(json.backdrop_path !== null) {
	          var img = document.createElement('img');
    	      img.src = 'https://image.tmdb.org/t/p/w185' + json.backdrop_path;
	          movieDesc.appendChild(img);
    	  }
    	  movieDesc.appendChild(document.createElement('br'));
    	  movieDesc.appendChild(document.createTextNode("Title : "));
    	  movieDesc.appendChild(document.createTextNode(movie_title));
    	  movieDesc.appendChild(document.createElement('br'));
    	  movieDesc.appendChild(document.createTextNode("Genre : "));
    	  var genre = [];
    	  var genre_display;
    	  for(var i=0; i<json.genres.length;++i)
    	  {
    	  	genre[i] = json.genres[i].name;
    	  }
    	  for(var i=0; i<genre.length;i++)
    	  {
    	  	if(i!=genre.length-1)
    	  	{
    	  	movieDesc.appendChild(document.createTextNode(genre[i]+", "));
    	  	continue;
    	  	}
    	  	movieDesc.appendChild(document.createTextNode(genre[i]));
    	  }
    	  movieDesc.appendChild(document.createElement('br'));
    	  movieDesc.appendChild(document.createTextNode("Overview : "));
    	  movieDesc.appendChild(document.createTextNode(json.overview));
       }
       
   };
   movie_details(id,title,movieDesc)
   xhr.send(null);
}

function movie_details(id,title,movieDesc) {
   var xhr = new XMLHttpRequest();
   xhr.open("GET", "proxy.php?method=/3/movie/"+id+"/credits");
   xhr.setRequestHeader("Accept","application/json");
   xhr.onreadystatechange = function () {
       if (this.readyState == 4) {
          var json = JSON.parse(this.responseText);
          var str = JSON.stringify(json,undefined,2);
    	  movieDesc.appendChild(document.createElement('br'));
    	  movieDesc.appendChild(document.createTextNode("Top Five Cast : "));
    	  var movie_cast = [];
    	  for(var i=0; i<5;i++)
    	  {
    	  	movie_cast[i] = json.cast[i].name;
    	  }
    	  for(var i=0; i<movie_cast.length;i++)
    	  {
    	  	if(i!=4)
    	  	{
    	  	movieDesc.appendChild(document.createTextNode(movie_cast[i]+", "));
    	  	continue;
    	  	}
    	  	movieDesc.appendChild(document.createTextNode(movie_cast[i]));
    	  }
       } 
	};
   xhr.send(null);
}
