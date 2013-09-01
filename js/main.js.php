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
 */
var worldApp = new function(){
		var continent = null;
		var country = null;
		var city = null;
		// states: 1-view continents; 2- view country; 3 - view cities; 4- view city detail
		var state = 1;

		
		var continents = [];
		var countries = [];
		var cities = [];



		this.goHome = function(){
			setState(1);

			showContinents();
			this.updateBreadcrumb();
		};


		

		this.setContinent = function(name){
			getCountries(name);
			continent = new Continent(name);
			setState(2);

			this.updateBreadcrumb();
		};




		this.addContinent = function(name){
			continents.push(new Continent(name));
		};




		this.addCity = function(city){
			cities.push(city);
		}




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




		function searchCountry(countryCode){
			for (var i in countries){
				if(countries[i].getCode() === countryCode){
					return countries[i];
				}
			};
		};




		function searchCity(cityId){
			cityId = parseInt(cityId);

			for (var i in cities){
				if(cities[i].getId() === cityId){
					return cities[i];
				}
			};
		};




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



		this.addCountry = function(_country){
			countries.push(_country);
		};



		function setState(s){
			state = s;
		};



		this.clearCountries = function(){
			countries = [];
		}



		this.clearCities = function(){
			cities = [];
		}



		// method to update the breadcrumb with current app state
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

