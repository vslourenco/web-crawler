<?php

class QueryBuilder
{
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function selectAll($table)
	{
		$statement = $this->pdo->prepare("Select * From {$table} AND ativo='1'");

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS);
	}

	public function delete($table, $id)
	{
		$sql = sprintf(
			"UPDATE %s SET ativo = 0 WHERE id = %s",
			$table,
			$id
		);

		try{
			$statement = $this->pdo->prepare($sql);
			$statement->execute();
		}catch (Exception $e){
			die($e->getMessage());
		}
	} 

	public function select($sql)
	{
		$statement = $this->pdo->prepare($sql);

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS);
	}

	public function execute($sql)
	{
		$statement = $this->pdo->prepare($sql);

		return $statement->execute();
	}
	
}