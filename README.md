CityFinder
==========
This is a simple project to test client side javascript.


You can view the  [live project here](http://www.demo.bernardosilva.com/cityfinder/ "CityFinder Live preview").



Tools used
----------
* Codeigniter PHP framework (2.1.4)
* jQuery JavaScript Library v1.10.2
* Twitter Bootstrap css + js framework (2.3.2)



###REST API DOC

> ##Continents
> `api/world/continents` --> List all continents  
> `api/world/continents/<continent-name>/countries` --> list all countries of continent <continent-name>
>
>
> ##Countries
> `api/world/countries` --> list all countries (not implemented)  
> `api/world/countries/<country-code>/cities`  --> list cities of country <country-code>  
>
> ##Cities
> `api/world/cities` --> list all cities (not implemented)  
> `api/world/cities/<city-id>` --> get city <city-id> details  




###Todo:
* Add reponsive rules to be in fullscreen on all screens
* Add friendly error notifications
* Improve the ajax requests needed for content allready downloaded
* Update all messed up characters in database



Note: some characters are wrong because they were inserted in database as they appear, is not an encodding problem.

Thks for watching.



Powered by [Bernardo Silva](http://www.bernardosilva.com/ "Personal Page")