<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class World extends REST_Controller
{

	// continents --> list all continents
	// continents/xx/countries --> list all countries of continent xx


	// countries --> list all countries
	// countries/xx/cities --> list cities of country xx

	// cities --> list all cities
	// cities/xx --> show city xx



	function continents_get($name = false, $resource = false){
    	
        if($name){
        	if($resource == 'countries'){
        		$this->load->model('world_model');
        		$data = $this->world_model->get_countries_of_continent( $name );
        	}else{
        		// return info about the continent named
        	}
        }else{
        	$this->load->model('world_model');
        	$data = $this->world_model->get_continents();
        }


    	
        if(isset($data) && $data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
						$this->response(array('error' => 'The specified resource does not exist!'), 404);        
   		 	}
  	}


   

		/**
     * method to get details about country resource
     *
     **/
    function countries_get($name = false, $resource = false){
        if($name){
        	if($resource == 'cities'){
        		// return all cities for country name
        		$this->load->model('world_model');
        		$data = $this->world_model->get_cities_of_country($name);
        	}else{
        		// return country name details
        		$this->load->model('world_model');
        		$data = $this->world_model->get_country($name);
        	}
        }else{
        	// return all countries
        }

        if(isset($data) && $data){
            $this->response($data, 200); // 200 being the HTTP response code
        }else{
						$this->response(array('error' => 'The specified resource does not exist or not found!'), 404);        
   		 	}
    }
    


    /**
     * method to get info about country
     *
     * @return void
     * @author 
     **/
    function cities($name = false){
    		if($name){
    			// return data about the named city
    		}else{
    			// return all cities data
    		}
    }
    
}