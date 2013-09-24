<?php

class job
{
	/* Attributes */
	private $id;			//int
	private $customer;		//int
	private $createdby;		//int
	private $passcode;		//varchar(256)
	private $title;			//varchar(256)
	private $created;		//int
	private $events;		//array of event
}

	
	//Constructor
	function __construct($arr)
	{
		$this->id = $arr['id'];
		$this->customer = $arr['customer'];
		$this->createdby = $arr['createdby'];
		$this->passcode = $arr['passcode'];
		$this->title = $arr['title'];
		$this->created = $arr['created'];
		$this->events = new events();
		
		//Grab events from SQL
		global $mysql;
		mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
		mysql_select_db($mysql['db']);
		
		$sql = "SELECT * FROM events WHERE job = '".mysql_real_escape_string($this->id)."'";
		$r = mysql_query($sql);
		
		//Insert into events object
		for($i = 0; $i < mysql_num_rows($r); $i++)
		{
			$events->addEvent(mysql_fetch_assoc($r));
		}
	}
	
	
	//Add Event
	//$e should be a fully formed event object
	function addEvent($e)
	{
		//Build database connection
		global $mysql;
		mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
		mysql_select_db($mysql['db']);
		
		//Build query
		$sql = "INSERT INTO events (`id`, `job`, `madeby`, `status`, `notes`, `created`, `adminonly`) VALUES (
			'".mysql_real_escape_string($e->id)."', 
			'".mysql_real_escape_string($e->job)."',
			'".mysql_real_escape_string($e->madeby)."',
			'".mysql_real_escape_string($e->status)."',
			'".mysql_real_escape_string($e->notes)."',
			'".mysql_real_escape_string($e->created)."',
			'".mysql_real_escape_string($e->adminonly)."');";
			
		//Insert
		mysql_query($sql);
	}


	//Get event count
	function getEventCount()
	{
		return count($this->events->events);
	}
	
	
	//Get a specific event
	function getEvent($id)
	{
		//Check the id is valid
		if($id < 1 || $id > count($this->events))
		{
			return false;
		}
		
		return $this->events->events[$id];
	}	


	/* Accessors */
	function getId()		{	return $this->id;			}
	function getCustomer()	{	return $this->customer;		}
	function getCreatedby()	{	return $this->createdby;	}
	function getPasscode()	{	return $this->passcode;		}
	function getTitle()		{	return $this->title;		}
	function getCreated()	{	return $this->created;		}

?>