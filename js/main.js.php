<?php
?>
<script>



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



function getCountries(continentName){
	continentName = continentName.replace(" ","_");
	
	$.ajax({
	  url: "api/world/continents/"+continentName+"/countries/format/json",
	  success: function(data){
	  	var htmlContent = '<ul class="listview">';
	  	var _country;
	  	worldApp.clearCountries();
	  	for(var i in data){
	  		console.log(data[i]);
	  		_country = new Country(data[i].code, data[i].name, data[i].population, data[i].region, data[i].life_expectacy, data[i].gnp);
	  		htmlContent += '<li><a data-type="country" data-name="'+_country.getCode()+'" href="">'+_country.getName()+'</a></li>';
	  		worldApp.addCountry(_country);
	  	}
	  	htmlContent += "</ul>";
	  	updateAppContent(htmlContent);
	  },
	  error: function(data){
	  	alert("erro");
	  },
	  dataType: "json"
	});
};



function getCities(countryCode){
	
	$.ajax({
	  url: "api/world/countries/"+countryCode+"/cities/format/json",
	  success: function(data){
	  	var htmlContent = '<ul class="listview">';
	  	var _city;
	  	worldApp.clearCities();
	  	for(var i in data){
	  		console.log(data[i]);
	  		_city = new City(data[i].id, data[i].name, data[i].district, data[i].population);
	  		htmlContent += '<li><a data-type="city" data-name="'+_city.getId()+'" href="">'+_city.getName()+'</a></li>';
	  		worldApp.addCity(_city);
	  	}
	  	htmlContent += "</ul>";
	  	updateAppContent(htmlContent);
	  },
	  error: function(data){
	  	alert("erro");
	  },
	  dataType: "json"
	});
};



function getCity(cityId){

};




function updateAppContent(htmlContent){
	$(".app-container").empty();
	$(".app-container").append(htmlContent);
	console.log(htmlContent);
}




var worldApp = new function(){
		var continent = null;
		var country = null;
		var city = null;
		// 1-view continents; 2- view country; 3 - view cities; 4- view city detail
		var state = 1;

		
		var continents = [];
		var countries = [];
		var cities = [];


		this.goHome = function(){
			setState(1);

			showContinents();
			this.updateBreadcrumb();
		};


		function showContinents(){
			$(".app-container").empty();
			
			var htmlContent = '<ul class="listview">';
	  	var _continent;
	  	for(var i in continents){
	  		console.log(continents[i]);
	  		//_country = new Country(data[i].code, data[i].name, data[i].population, data[i].region, data[i].life_expectacy, data[i].gnp);
	  		_continent = continents[i];
	  		htmlContent += '<li><a data-type="continent" data-name="'+_continent.getName()+'" href="">'+_continent.getName()+'</a></li>';
	  	}
	  	htmlContent += "</ul>";
	  	
			$(".app-container").append(htmlContent);
		};




		this.setContinent = function(name){
			setState(2);
			continent = new Continent(name);

			this.updateBreadcrumb();
		};

		this.addContinent = function(name){
			continents.push(new Continent(name));
		};


		this.addCity = function(city){
			cities.push(city);
		}


		this.setCountry = function(countryCode){
			setState(3);

			country = searchCountry(countryCode);

			this.updateBreadcrumb();
		};


		this.setCity = function(cityId){
			city = searchCity(cityId);
			console.log('search city with ID:'+cityId);
			
			if(!city){
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
				console.log(cities[i].getId());
				if(cities[i].getId() === cityId){
					return cities[i];
				}
			};
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
		}



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
};




<?php
	foreach ($list_continents as $row) {
		?>
			<!-- worldApp.addContinent("<?php echo $row->continent; ?>"); -->
		<?php
	}
?>










$(document).on( 'click', 'a', function(event){
	
	event.preventDefault();
	var type = this.getAttribute("data-type");
	var name = this.getAttribute("data-name");

	if(type === 'continent'){
		// get countries for continent
		getCountries(name);
		worldApp.setContinent(name);

	}else if(type === 'country'){
		// get cities for specified country
		var countryCode = name;
		getCities(countryCode);

		worldApp.setCountry(countryCode); // select the country

	}else if(type === 'city'){
		// get city details
		worldApp.setCity(name);
	}else if(type === 'home'){
		worldApp.goHome();
	}else{
			// invalid resource type
		return false;
	}

	console.log('continent-->'+name);
});







</script>

