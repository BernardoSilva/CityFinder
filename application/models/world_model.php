<?php

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class World_model extends CI_Model{

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function __construct(){
			parent::__construct();
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function get_continents()
	{
		$sql_query = "SELECT DISTINCT continent FROM countries;";
		$result = $this->db->query($sql_query);

		if($result->num_rows() > 0){
			return $result->result();
		}

		return FALSE;
	}





	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function get_countries_of_continent($name){
		$sql_query = "SELECT code, name, region, population, life_expectancy, gnp 
										FROM countries 
										WHERE continent LIKE ?;";
		$result = $this->db->query($sql_query, array($name));

		if($result->num_rows() > 0){
			return $result->result();
		}

		return FALSE;
	}




	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function get_cities_of_country($code){
		$sql_query = "SELECT id, name, district, population
									FROM cities 
									WHERE country_code LIKE ?;";
		$result = $this->db->query($sql_query, array($code));

		if($result->num_rows() > 0){
			return $result->result();
		}

		return FALSE;				
	}




} // END class 