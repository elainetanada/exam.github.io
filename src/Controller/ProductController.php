<?php

namespace App\Controller;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\ResponseService;
/*
 * Product Controller
 */
class ProductController {
    const ASSET_IMAGE_DIR = 'assets/images/';
    /** @var RepositoryInterface $repository */
    private $repository;

    /*
	 * Class Constructor. Using Dependency Inversion.
     * 
	 */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /*
	 * Display Product List Page
	 */
    public function index()
    {
        $allProducts = $this->repository->getAll();
        $productsArray = [];

		foreach($allProducts as $product) {
            $productsArray[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'unit' => $product['unit'],
                'price' => $product['price'],
                'expiry_date' => $product['expiry_date'],
                'available_inventory' => $product['available_inventory'],
                'available_inventory_price' => number_format($product['available_inventory'] * $product['price'], 2),
                'image' => self::ASSET_IMAGE_DIR . $product['id'] . '/' . $product['image'],
                'created_at' => $product['created_at'],
                'updated_at' => $product['updated_at'],
            ];
		}
        
        include '../views/product/index.php';
    }

    /*
	 * Display Product List Page
	 */
    public function getAll()
    {
        $allProducts = $this->repository->getAll();
        $productsArray = [];

		foreach($allProducts as $product) {
            $productsArray[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'unit' => $product['unit'],
                'price' => $product['price'],
                'expiry_date' => $product['expiry_date'],
                'available_inventory' => $product['available_inventory'],
                'available_inventory_price' => number_format($product['available_inventory'] * $product['price'], 2),
                'image' => self::ASSET_IMAGE_DIR . $product['id'] . '/' . $product['image']
            ];
		}
        
        (new ResponseService(json_encode($productsArray, JSON_PRETTY_PRINT), 200, ['Content-Type' => 'application/json']))->send();
        exit;
    }

    /*
	 * Display Create Product Page
	 */
    public function create()
    {
        include '../views/product/create.php';
    }

    /*
	 * Store Product
	 */
    public function store()
    {
        $request = array_filter($_POST); // remove fields with empty values
        $file = $_FILES;
        $uploadFile =  basename($_FILES['image']['name']);
        $request['image'] = $uploadFile;
        $result = ['success' => false, 'message' => 'Failed to save product'];
        $statusCode = 400;
        
        $newProduct = $this->repository->store($request);

        if($newProduct) {
            if(!file_exists('assets/images/'. $newProduct)) {
                mkdir('assets/images/'. $newProduct, 0775);
            }

            $result = ['success' => true, 'message' => 'Successfully saved but there was a problem with uploading the file.'];

            if (move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/'. $newProduct . '/'. $uploadFile)) {
                $request['image'] = $uploadFile;

                $result = ['success' => true, 'message' => 'Successfully saved!'];
            } 
            $statusCode = 200;
        }
        
        (new ResponseService(json_encode($result, JSON_PRETTY_PRINT), $statusCode, ['Content-Type' => 'application/json']))->send();
        exit;
    }

    /*
	 * Display Edit Product Page
     * 
     * @param array $params
	 */
    public function edit(array $params)
    {
        $request = array_filter($_POST); // remove fields with empty values
        $product = $this->repository->get($params[0]);
        $product['expiry_date'] = date("Y-m-d", strtotime($product['expiry_date']));
        $product['image'] = '/'.self::ASSET_IMAGE_DIR . $product['id'] . '/' . $product['image'];
        
        include '../views/product/edit.php';
    }

    /*
	 * Update Product
	 */
    public function update(array $params)
    {
        $request = array_filter($_POST); // remove fields with empty values
        
        $file = $_FILES;
        $uploadFile =  ($file) ? basename($_FILES['image']['name']) : '';
        $request['image'] = $uploadFile;
        $result = ['success' => false, 'message' => 'Failed to update product'];
        $statusCode = 400;
        
        $updateProduct = $this->repository->update($params[0], $request);

        if($updateProduct) {
            if(!file_exists('assets/images/'. $updateProduct)) {
                mkdir('assets/images/'. $params[0], 0775);
            }

            if ($uploadFile && move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/'. $params[0] . '/'. $uploadFile)) {
                $request['image'] = $uploadFile;

               
            } 
            $result = ['success' => true, 'message' => 'Successfully updated!'];
            $statusCode = 200;
        }
        
        (new ResponseService(json_encode($result, JSON_PRETTY_PRINT), $statusCode, ['Content-Type' => 'application/json']))->send();
        exit;
    }

    /*
	 * Delete a Product
     * 
     * @param array $params
	 */
    public function delete(array $params)
    {
        $product = $this->repository->delete($params[0]);
        
        (new ResponseService(json_encode(['success' => true, 'message' => 'Successfully deleted!'], JSON_PRETTY_PRINT), 200, ['Content-Type' => 'application/json']))->send();
        exit;
    }
}