<script type="text/javascript">



/**
 * Class Continent
 */
var Continent = function(name){
	var _name = name;

	this.getName = function(){
		return _name;
	};
}





/**
 * Class Country
 */
var Country = function(code, name, population, region, life_expectacy, gnp){
	var _code = code;
	var _name = name;
	var _population = population;
	var _region = region;
	var _life_expectacy = life_expectacy;
	var _gnp = gnp;

	this.getCode = function(){
		return _code;
	};

	this.getName = function(){
		return _name;
	};

	this.getPopulation = function(){
		return _population;
	};

	this.getRegion = function(){
		return _region;
	};

	this.getLifeExpectancy = function(){
		return life_expectacy;
	};

	this.getNGP = function(){
		return _gnp;
	};

};






/**
 * Class City
 */
var City = function(id, name, district, population){
	var _id = parseInt(id);
	var _name = name;
	var _district = district;
	var _population = population;


	this.getId = function(){
		return _id;
	}

	this.getName = function(){
		return _name;
	};

	this.getDistrict = function(){
		return _district;
	};

	this.getPopulation = function(){
		return _population;
	};
};








/**
 * Main App Begin
 * app to nav between continents, countries and cities
 *
 */
var worldApp = new function(){
		var continent 	= null;
		var country 		= null;
		var city 				= null;
		// states: 1-view continents; 2- view country; 3 - view cities; 4- view city detail
		var state 			= 1;
		var continents 	= [];
		var countries 	= [];
		var cities 			= [];



		/**
		 * method to navigate to homepage (select continent view)
		 */
		this.goHome = function(){
			setState(1);

			showContinents();
			this.updateBreadcrumb();
		};


		
		/**
		 * method used to set the continent selected
		 * @param string name - name of the continent selected
		 */
		this.setContinent = function(name){
			getCountries(name);
			continent = new Continent(name);
			setState(2);

			this.updateBreadcrumb();
		};



		/**
		 * method to create and add a continent to application data
		 * @param string name - name of the continent to be added
		 */
		this.addContinent = function(name){
			continents.push(new Continent(name));
		};



		/**
		 * method to add a city to a list of cities
		 * @param City object 
		 */
		this.addCity = function(city){
			cities.push(city);
		}



		/**
		 * method to set the selected country and display the cities for the selected country
		 * @param string code of the country selected  
		 */
		this.setCountry = function(countryCode){
			getCities(countryCode);

			country = searchCountry(countryCode);
			if(!country){
				country = null;
				console.error("Country not found!");
				return false;
			}else{
				showCities();
				setState(3);
				this.updateBreadcrumb();
			}
		};



		/**
		 * method to set the selected city and display the city details
		 * @param int id - unique id of city from database
		 */
		this.setCity = function(cityId){
			city = searchCity(cityId);
			
			if(!city){
				city = null;
				console.log('City not found!');
			}
			setState(4);
			showCityDetails();
			this.updateBreadcrumb();
		};




		/**
		 * method to search for a country in the list of countries in worldApp
		 * @param string code - unique code of a country
		 */
		function searchCountry(countryCode){
			for (var i in countries){
				if(countries[i].getCode() === countryCode){
					return countries[i];
				}
			};
		};




		/**
		 * method to search for a city in the worldApp list of cities
		 * @param int Id - unqieu identification of city from database
		 */
		function searchCity(cityId){
			cityId = parseInt(cityId);

			for (var i in cities){
				if(cities[i].getId() === cityId){
					return cities[i];
				}
			};
		};




		/**
		 * method to display the continents in app list of continents
		 */
		function showContinents(){
			$(".app-container").empty();
			var htmlContent = '<ul class="listview">';
	  	var _continent;
	  	for(var i in continents){
	  		_continent = continents[i];
	  		htmlContent += '<li><a data-type="continent" data-name="'+_continent.getName()+'" href="">'+_continent.getName()+'</a></li>';
	  	}
	  	htmlContent += "</ul>";
	  	
			$(".app-container").append(htmlContent);
		};



		/**
		 * method to display a the list of countries in app list of countries
		 */
		function showCountries(){
			$(".app-container").empty();
			
			var htmlContent = '<ul class="listview">';
			var _country;
			for(var i in countries){
				_country = countries[i];
				htmlContent += '<li><a data-type="country" data-name="'+_country.getCode()+'" href="">'+_country.getName()+'</a></li>';
			}
			htmlContent += '</ul>';
	  	
			$(".app-container").append(htmlContent);
		};


		
		/**
		 * method to show all cities in app list of cities
		 */
		function showCities(){
			$(".app-container").empty();
			
			var htmlContent = '<ul class="listview">';
			var _city;
			for(var i in cities){
				_city = cities[i];
				htmlContent += '<li><a data-type="city" data-name="'+_city.getId()+'" href="">'+_city.getName()+'</a></li>';
			}
			htmlContent += '</ul>';
	  	
			$(".app-container").append(htmlContent);
		};



		/**
		 * method to show the details of the current selected city
		 */
		function showCityDetails(){
			$(".app-container").empty();
			
			var htmlContent = '<div class="city-detail-container">';
					htmlContent += '<label>District</label>';
	  			htmlContent += '<span class="detail-text">'+city.getDistrict()+'</span>';
	  			htmlContent += '<label>Population</label>';
	  			htmlContent += '<span class="detail-text">'+city.getPopulation()+'</span>';
	  		htmlContent += '</div>';
	  	
			$(".app-container").append(htmlContent);
		};



		/**
		 * add a country to the app list of countries
		 */
		this.addCountry = function(_country){
			countries.push(_country);
		};


		/**
		 * set the current app state
		 * @param int state
		 * valid states:
		 * 1- continents view
		 * 2- contries view
		 * 3- cities view
		 * 4- city detail view
		 */
		function setState(s){
			state = s;
		};



		/**
		 * erase all app list of countries
		 * this is usefull to delete the countries when the continent is changed to keep data relation up to date
		 */
		this.clearCountries = function(){
			countries = [];
		}


		/**
		 * erase all app list of cities
		 * this is used when the country if changed and we want to have only the cities of the selected country
		 */
		this.clearCities = function(){
			cities = [];
		}



		/**
		 * this method draw the app breadcrumb based on the current app state and the selected options
		 */
		this.updateBreadcrumb = function(){
			$('.breadcrumb-list').empty();

			var _breadcrumb = '';
			if(state === 1){
				_breadcrumb += '<li>Home</li>';
			}else if(state === 2){
				_breadcrumb += '<li><a data-type="home" href="#">Home</a><span class="divider"> > </span></li>';
				_breadcrumb += '<li>'+continent.getName()+'</li>';
			}else if(state === 3){
				_breadcrumb += '<li><a data-type="home" href="#">Home</a><span class="divider"> > </span></li>';
				_breadcrumb += '<li><a data-type="continent" data-name="'+continent.getName()+'" href="#">'+continent.getName()+'</a><span class="divider"> > </span></li>';
				_breadcrumb += '<li>'+country.getName()+'</li>';
			}else if(state === 4){
				_breadcrumb += '<li><a data-type="home" href="#">Home</a><span class="divider"> > </span></li>';
				_breadcrumb += '<li><a data-type="continent" data-name="'+continent.getName()+'" href="#">'+continent.getName()+'</a><span class="divider"> > </span></li>';
				_breadcrumb += '<li><a data-type="country" data-name="'+country.getCode()+'" href="#">'+country.getName()+'</a><span class="divider"> > </span></li>';
				_breadcrumb += '<li>'+city.getName()+'</li>';
			}

			$('.breadcrumb-list').append(_breadcrumb);
		};



		/**
		 * method to get cities of a specific country and add them to the app list of cities
		 */
		function getCities(countryCode){	
			$.ajax({
			  url: "api/world/countries/"+countryCode+"/cities/format/json",
			  success: function(data){
			  	var _city;
			  	worldApp.clearCities();
			  	for(var i in data){
			  		_city = new City(data[i].id, data[i].name, data[i].district, data[i].population);
			  		worldApp.addCity(_city);
			  	}
			  },
			  complete:function(){
			  	showCities();
			  },
			  error: function(data){
			  	alert("This Country does not have cities!");
			  },
			  dataType: "json"
			});
		};




		/**
		 * method to get 
		 */
		function getCountries(continentName){
			continentName = continentName.replace(" ","_");
			
			$.ajax({
			  url: "api/world/continents/"+continentName+"/countries/format/json",
			  success: function(data){
			  	var _country;
			  	worldApp.clearCountries();
			  	for(var i in data){
			  		_country = new Country(data[i].code, data[i].name, data[i].population, data[i].region, data[i].life_expectacy, data[i].gnp);
			  		worldApp.addCountry(_country);
			  	}
			  },
			  complete: function(){
			  	showCountries();
			  },
			  error: function(data){
			  	console.error("No data for this resource:"+continentName);
			  },
			  dataType: "json"
			});
		};


}; 	// END WORLD APP CLASS







/**
 * link handler
 */
$(document).on( 'click', 'a', function(event){
	event.preventDefault();
	var type = this.getAttribute("data-type");
	var name = this.getAttribute("data-name");

	if(type === 'continent'){ // get countries for continent
		worldApp.setContinent(name);

	}else if(type === 'country'){	// get cities for specified country		
		worldApp.setCountry(name); // select the country

	}else if(type === 'city'){
		worldApp.setCity(name); // get city details

	}else if(type === 'home'){
		worldApp.goHome();

	}else{
		return false;	// invalid resource type
	}
});







</script>

