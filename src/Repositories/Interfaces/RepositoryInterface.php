<?php

namespace App\Repositories\Interfaces;

/*
 * Repository Inteface
 */
interface RepositoryInterface {

    /**
	* Get All
    * 
    * @return array
	*/
    public function getAll();

    /**
	* Get by id
    *
    * @param integer id
    * @return array
	*/
	public function get($id);

    /**
	* Store Data
    *
    * @param array $payload
    * @return array
	*/
    public function store(array $payload);

    /**
	* Delete Data
    *
    * @param integer $id
    * @return array
	*/
    public function delete($id);
}