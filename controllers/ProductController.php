<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
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
            Request::redirect('/product');
        }

    }

    public function save(Request $request)
    {
        $this->productRepository->create($request->all());

        Request::redirect('/product');
    }

    public function update(Request $request, int $id)
    {
        try {
            $this->productRepository->update($request->all(), $id);

            Request::redirect('/product');
        } catch (ModelNotFoundException $exception) {
            Request::redirect('/product');
        }
    }

    public function delete(int $id)
    {
        $this->productRepository->delete($id);

        Request::redirect('/product');
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import()
    {
        $this->productsImport->importFromUploadedFile();

        Request::redirect('/product');
    }

}
