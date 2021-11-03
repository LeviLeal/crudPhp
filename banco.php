<?php
class BancoPDO
{
	var $dbname = "local_hub";
	var $hostname = "localhost";
	var $user = "root";
	var $password = "";

	public $con;

	function __construct()
	{
		try 
		{
			$con = new PDO("mysql:dbname=".$this->dbname.";host=".$this->hostname, $this->user, $this->password);
			$this->con = $con;
		}
		catch (PDOException $e)
		{
				echo "Erro de PDOException: " . $e->getMessage();
		}
		catch(Exception $e)
		{
			echo "Erro genérico" . $e->getMessage();
		}
	}

	function query ($query)
	{
		$stmt = $this->con->prepare($query); 
		$stmt->execute();
	}

	// function select($table, $campo, $value)
	// {
	// 	$stmt = $this->con->prepare("SELECT * FROM {$table} WHERE {$campo} = :value");
	// 	$stmt->bindValue(":value", $value);
	// 	$stmt->execute();
	// 	return $stmt->rowCount();
	// }
	
	function select($table, $campo, array $value)
	{

		$teste = [];

		for ($i = 0; $i < count($value); $i++) 
		{ 
			$stmt = $this->con->prepare("SELECT * FROM {$table} WHERE $campo = :$campo");
			$stmt->bindValue(":$campo", $value[$i]);
			$stmt->execute();
			array_push($teste, $stmt->fetch(PDO::FETCH_ASSOC));
		}
		return $teste;
	
	}
	
	function insert($table, $campo, $value)
	{
		$stmt = $this->con->prepare("INSERT INTO {$table} ({$campo}) VALUES (:value)");
		$stmt->bindValue(":value", $value);
		$stmt->execute();
	}

	function delete($table, $campo, $value)
	{
		$stmt = $this->con->prepare("DELETE FROM {$table} WHERE {$campo} = :value");
		$stmt->bindValue(":value", $value);
		$stmt->execute();
	}

	function update($table, $campo, $value, $condition)
	{
		$stmt = $this->con->prepare("UPDATE {$table} SET {$campo} = :value WHERE $condition");
		$stmt->bindValue(":value", $value);
		$stmt->execute();
	}
}