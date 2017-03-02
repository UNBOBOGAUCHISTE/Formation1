<?php
class App
{
	static $db = null;
	
	static function getDatabase()
	{
		if(!self::$db)
		{
			self::$bd = new Database('root','','formationppe');
		}
		return sel::$db;
	}
?>