<?php

class event
{
	/* Attributes */
	var $id;
	var $job;
	var $madeby;
	var $status;
	var $notes;
	var $createdby;
	var $adminonly;
}

class events
{
	/* Attributes */
	var $events = array();
	
	function addEvent($event)
	{
		$e = new event();
		
		$e->id = $event['id'];
		$e->job = $event['job'];
		$e->madeby = $event['madeby'];
		$e->status = $event['status'];
		$e->notes = $event['notes'];
		$e->createdby = $event['createdby'];
		$e->adminonly = $event['adminonly'];
	
		$this->events[] = $e;
	}
}

?>