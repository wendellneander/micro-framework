<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Session;
use Core\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Repository\CategoryRepository;
use Repository\ProductRepository;
use Repository\StoreRepository;
use Support\ProductsImport;
use Support\XlsxReader;

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
    /**
     * @var ProductsImport
     */
    private $productsImport;

    public function __construct(
        ProductRepository $productRepository,
        StoreRepository $storeRepository,
        CategoryRepository $categoryRepository,
        ProductsImport $productsImport
    )
    {
        $this->productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productsImport = $productsImport;
    }

    public function index(Request $request)
    {
        $params = $request->all();

        $search = isset($params['q']) && $params['q'] ? $params['q'] : null;

        $categoryId = isset($params['category']) && $params['category'] ? $params['category'] : null;

        $categories = $this->categoryRepository->all();

        $stores = $this->storeRepository->searchByProductNameAndCategory($search, $categoryId, ['products.category'], true);

        $this->view('product/index', [
            'stores' => $stores,
            'search' => $search,
            'category_id' => $categoryId,
            'categories' => $categories,
        ]);
    }

    public function productsByStoreAndCategory(Request $request, $storeId, $categoryId)
    {
        $params = $request->all();

        $search = isset($params['q']) && $params['q'] ? $params['q'] : null;

        $categories = $this->categoryRepository->all();

        $store = $this->storeRepository->show($storeId);

        $stores = $this->storeRepository->searchByProductNameAndStoreAndCategory(
            $search,
            $storeId,
            $categoryId,
            ['products.category'],
            true
        );

        $this->view('product/index', [
            'stores' => $stores,
            'search' => $search,
            'category_id' => $categoryId,
            'categories' => $categories,
            'store_name' => $store ? $store->name : ''
        ]);
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

            $this->view('product/form', ['product' => $product, 'stores' => $stores, 'categories' => $categories]);
        } catch (ModelNotFoundException $exception) {
            Session::flash('message', $exception->getMessage());

            Request::redirect('/products');
        } catch (\Exception $exception) {

            Session::flash('message', $exception->getMessage());

            Request::redirect("/product/edit/$id");
        }

    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();

            Validator::getInstance()->validate($data, [
                'name' => 'string|required',
                'price' => 'numeric|required',
                'store_id' => 'integer|required',
                'category_id' => 'integer|required',
            ]);

            $this->productRepository->create($request->all());
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());

            Request::redirect('/product/new');
        }

        Request::redirect('/products');
    }

    public function update(Request $request, int $id)
    {
        try {
            $data = $request->all();

            Validator::getInstance()->validate($data, [
                'name' => 'string|required',
                'price' => 'numeric|required',
                'store_id' => 'integer|required',
                'category_id' => 'integer|required',
            ]);

            $this->productRepository->update($request->all(), $id);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());
        }

        Request::redirect('/products');
    }

    public function delete(int $id)
    {
        $this->productRepository->delete($id);

        Request::redirect('/products');
    }

    /**
     *
     */
    public function import()
    {
        try {
            $this->productsImport->importFromUploadedFile();
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());
        }

        Request::redirect('/product');

    }

}
