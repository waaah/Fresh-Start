<?php
//resume information
class DataBaseFunction{
	public function setQueryandParameters($query,$parameters){
		$this->obj = new DatabaseConnection();
		$this->query = $this->obj->setQuery($query);
		$this->parameters = $parameters;
		$this->fetchData();
	}
	private function fetchData(){
		$this->res = $this->obj->executeQuery($this->parameters,true);
		//$this->cnt = mysql_num_rows($this->res);
		$this->data = array();
		foreach ((array)$this->res as $row) {
			array_push($this->data,$row);
		}
		
	}
	function setValue($accno){
		$this->accno = $accno;
	}
	public function getQuery(){
		return $this->query;
	}
	public function getRow($rowInDatabase){
		return $this->data[$rowInDatabase-1];
	}
	public function getAllData(){
		return $this->data;
	}
	public function closeConnection(){
		mysql_close($this->con);
	}
	

}
?>
