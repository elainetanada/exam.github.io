<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\DatabaseService as DB;

class ProductRepository implements RepositoryInterface{

    /** @var DatabaseService $instance */
    private $db;
    
    /**
	* ProductRepository Constructor
	*/
    public function __construct() {
        $this->db = DB::getInstance();
    }

    /**
	* Get Product
    * 
    * @return array
	*/
	public function getAll()
	{
		return $this->db->fetchAllQuery('SELECT * FROM `product`');
	}

    /**
	* Get by id
    *
    * @param integer id
    * @return array
	*/
	public function get($id)
	{
		return $this->db->fetchQuery('SELECT * FROM `product` WHERE id = ' . $id);
	}

    /**
	* Store Data
    *
    * @param array $payload
    * @return array
	*/
	public function store(array $payload)
	{
		try{
			$sql = "INSERT INTO `product` (`name`, `unit`, `price`, `expiry_date`, `available_inventory`, `image`) VALUES('". $payload['name'] . "','" . $payload['unit'] . "'," . $payload['price'] . ",'" . $payload['expiry_date'] . "'," . $payload['available_inventory'] . ",'" . $payload['image'] . "')";
			$this->db->executeQuery($sql);
			
			return $this->db->getLastInsertId($sql);
		} catch(Exception $e) {
			return $e->getMessage();
		}
        
	}

	/**
	* Update Data
    *
	* @param string $id
    * @param array $payload
    * @return array
	*/
	public function update($id, array $payload)
	{
		try{
			
			$sql = "UPDATE product SET
				 	`name` = '". $payload['name'] . "',
					`unit` = '". $payload['unit'] . "',
					`price` = " . $payload['price'] . ",
					`expiry_date` = '". $payload['expiry_date'] . "',
					`available_inventory` = " . $payload['available_inventory'] . "";
					
				
			if(isset($payload['image']) && $payload['image']) {
				$sql .= ", `image` = '". $payload['image'] . "'";
			}
			
			$sql .= " WHERE `id` = " . $id;
			
			$test = $this->db->executeQuery($sql);

			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
        
	}

    /**
	* Delete Data
    *
    * @param integer $id
    * @return array
	*/
	public function delete($id)
	{
        $this->db->executeQuery("DELETE FROM `product` WHERE `id`=" . $id);
	}
}