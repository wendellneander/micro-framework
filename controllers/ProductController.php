<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Repository\CategoryRepository;
use Repository\ProductRepository;
use Repository\StoreRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var StoreRepository
     */
    private $storeRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        StoreRepository $storeRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $params = $request->all();

        $search = $params['q'];

        $products = $this->productRepository->searchByName($search);

        $this->view('product/index', ['product' => $products, 'search' => $search]);
    }

    public function create()
    {
        $stores = $this->storeRepository->all();

        $categories = $this->categoryRepository->all();

        $this->view('product/form', ['stores' => $stores, 'categories' => $categories]);
    }

    public function edit(int $id)
    {
        try {
            $product = $this->productRepository->show($id);

            $stores = $this->storeRepository->all();

            $categories = $this->categoryRepository->all();

            $this->view('product/form', ['product' => $product,'stores' => $stores, 'categories' => $categories]);
        } catch (ModelNotFoundException $exception) {
            Request::redirect('/');
        }

    }

    public function save(Request $request)
    {
        $this->productRepository->create($request->all());

        Request::redirect('/');
    }

    public function update(Request $request, int $id)
    {
        try {
            $this->productRepository->update($request->all(), $id);

            Request::redirect('/');
        } catch (ModelNotFoundException $exception) {
            Request::redirect('/');
        }
    }

    public function delete(int $id)
    {
        $this->productRepository->delete($id);

        Request::redirect('/');
    }

}
