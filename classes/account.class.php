<?php

class Account
{
	/* Attributes */
	private $id;			//int(11)
	private $username;		//varchar(32)
	private $password;		//varchar(64)
	private $fname;			//varchar(64)
	private $lname;			//varchar(64)
	private $phone1;		//varchar(32)
	private $phone2;		//varchar(32)
	private $email;			//varchar(256)
	private $address;		//varchar(512)
	private $notes;			//varchar(2048)
	private $created;		//int(11)
	
	
	
	/* Constructor */
	function __construct($arr)
	{
		$this->id = $arr['id'];
		$this->username = $arr['username'];
		$this->password = $arr['password'];
		$this->fname = $arr['fname'];
		$this->lname = $arr['lname'];
		$this->phone1 = $arr['phone1'];
		$this->phone2 = $arr['phone2'];
		$this->email = $arr['email'];
		$this->address = $arr['address'];
		$this->notes = $arr['notes'];
		$this->created = $arr['created'];
	}


	
	/* Methods */
	function getName()
	{
		return $this->fname . " " . $this->lname;
	}

	
	
	/* Modifiers */
	function setPassword($i)	{	$this->password = sha1($i);	}
	function setFname($i)		{	$this->fname = $i;			}
	function setLname($i)		{	$this->lname = $i;			}
	function setPhone1($i)		{	$this->phone1 = $i;			}
	function setPhone2($i)		{	$this->phone2 = $i;			}
	function setEmail($i)		{	$this->email = $i;			}
	function setAddress($i)		{	$this->address = $i;		}
	function setNotes($i)		{	$this->notes = $i;			}
	
	
	
	/* Accessors */
	function getId()		{	return $this->id;			}
	function getUsername()	{	return $this->username;		}
	function getPassword()	{	return $this->password;		}
	function getFname()		{	return $this->fname;		}
	function getLname()		{	return $this->lname;		}
	function getPhone1()	{	return $this->phone1;		}
	function getPhone2()	{	return $this->phone2;		}
	function getEmail()		{	return $this->email;		}
	function getAddress()	{	return $this->address;		}
	function getNotes()		{	return $this->notes;		}
	function getCreated()	{	return $this->created;		}
}


//Get an account
function getAccount($id)
{
	//Build connection
	global $mysql;
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);
	
	//Build query
	$sql = "SELECT * FROM accounts WHERE id = '".mysql_real_escape_string($id)."' LIMIT 1";
	
	$r = mysql_query($sql);
	
	//Check an account was found
	if(mysql_num_rows($r) < 1)
	{
		return false;
	}
	
	//Instantiate Object
	$acc = new Account(mysql_fetch_assoc($r));
	
	return $acc;
}


function getAccountFromUserPass($user, $pass)
{
	//Build connection
	global $mysql;
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);
	
	//Build query
	$sql = "SELECT * FROM accounts WHERE username = '".mysql_real_escape_string($user)."' AND password = '".mysql_real_escape_string($pass)."' LIMIT 1";
	
	$r = mysql_query($sql);
	
	//Check an account was found
	if(mysql_num_rows($r) < 1)
	{
		return false;
	}
	
	//Instantiate Object
	$acc = new Account(mysql_fetch_assoc($r));
	
	return $acc;
}


function createAccount($arr)
{
	//Build connection
	global $mysql;
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);
	
	//Build query
	$sql = "INSERT INTO accounts (`id`, `username`, `password`, `fname`, `lname`, `phone1`, `phone2`, `email`, `address`, `notes`, `created`) VALUES ( NULL, 
		'".mysql_real_escape_string($arr['username'])."',
		SHA1('".mysql_real_escape_String($arr['password'])."'),
		'".mysql_real_escape_string($arr['fname'])."',
		'".mysql_real_escape_string($arr['lname'])."',
		'".mysql_real_escape_string($arr['phone1'])."',
		'".mysql_real_escape_string($arr['phone2'])."',
		'".mysql_real_escape_string($arr['email'])."',
		'".mysql_real_escape_string($arr['address'])."',
		'".mysql_real_escape_string($arr['notes'])."',
		UNIX_TIMESTAMP() ); ";
		
	mysql_query($sql);
}


function updateAccount($acc)
{
	//Build connection
	global $mysql;
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);
	
	//Build query
	$sql = "UPDATE accounts SET
		password = '".mysql_real_escape_string($acc->getPassword())."',
		fname    = '".mysql_real_escape_string($acc->getFname())."',
		lname    = '".mysql_real_escape_string($acc->getLname())."',
		phone1   = '".mysql_real_escape_string($acc->getPhone1())."',
		phone2   = '".mysql_real_escape_string($acc->getPhone2())."',
		email    = '".mysql_real_escape_string($acc->getEmail())."',
		address  = '".mysql_real_escape_string($acc->getAddress())."',
		notes    = '".mysql_real_escape_string($acc->getNotes())."'
		WHERE id = '".mysql_real_escape_string($acc->getId())."' LIMIT 1; ";
		
	mysql_query($sql);
}



?>