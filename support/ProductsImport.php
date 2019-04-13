<?php

namespace Support;

use Illuminate\Support\Facades\DB;
use Models\Product;
use Repository\CategoryRepository;
use Repository\ProductRepository;
use Repository\StoreRepository;

class ProductsImport extends XlsxReader
{
    /**
     * @var array $rules
     */
    private $rules = [
        'name' => 'required|string',
        'price' => 'required|numeric',
        'store_id' => 'required|integer|exists:stores,id',
        'category' => 'required|string|unique:categories,name',
    ];

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Product[]|null $products
     */
    private $products = [];
    /**
     * @var StoreRepository
     */
    private $storeRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ProductsImport constructor.
     * @param ProductRepository $productRepository
     * @param StoreRepository $storeRepository
     * @param CategoryRepository $categoryRepository
     */
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

    /**
     * @return void|null
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \Exception
     */
    public function importFromUploadedFile()
    {
        parent::importFromUploadedFile();

        $this->run();
    }

    /**
     * @return Product[]|null
     * @throws \Exception
     */
    private function run()
    {
        try {
            DB::beginTransaction();

            foreach ($this->rows as $index => $row) {
                $rowParsed = $this->parseRow($row);

                $this->validateRow($rowParsed, $index);

                $data = $this->createCategory($rowParsed);

                $this->persistRow($data);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw new $exception;
        }


        return $this->products;
    }

    /**
     * @param $row
     * @return array
     */
    private function parseRow($row)
    {
        return [
            'name' => $row[0],
            'price' => $row[1],
            'store_id' => (int)$row[2],
            'category' => $row[3],
        ];
    }

    /**
     * @param array $row
     * @param int $index
     * @throws \Exception
     */
    private function validateRow(array $row, int $index)
    {
        $index += 1;

        $this->validateRequiredFields($row, $index);

        $this->validateTypeOfFields($row, $index);

        $this->validateDatabaseRules($row, $index);
    }

    /**
     * @param array $row
     * @param int $index
     * @throws \Exception
     */
    private function validateRequiredFields(array $row, int $index)
    {
        if (!isset($row['name'])) {
            throw new \Exception('name attribute not set in line ' . $index);
        }

        if (!isset($row['price'])) {
            throw new \Exception('price attribute not set in line ' . $index);
        }

        if (!isset($row['store_id'])) {
            throw new \Exception('store_id attribute not set in line ' . $index);
        }

        if (!isset($row['category'])) {
            throw new \Exception('category attribute not set in line ' . $index);
        }

        if (!$row['name'] || !$row['price'] || !$row['store_id'] || !$row['category']) {
            throw new \Exception('missing required attributes in line ' . $index);
        }
    }

    /**
     * @param array $row
     * @param int $index
     * @throws \Exception
     */
    private function validateTypeOfFields(array $row, int $index)
    {
        if (!is_string($row['name'])) {
            throw new \Exception('name must be a string in line ' . $index);
        }

        if (!is_numeric($row['price'])) {
            throw new \Exception('price must be a numeric value in line ' . $index);
        }

        if (!is_integer($row['store_id'])) {
            throw new \Exception('store_id must be a integer value in line ' . $index);
        }

        if (!is_string($row['category'])) {
            throw new \Exception('category must be a string in line ' . $index);
        }
    }

    /**
     * @param array $row
     * @param int $index
     * @throws \Exception
     */
    private function validateDatabaseRules(array $row, int $index)
    {
        if (!$this->storeRepository->exists('id', $row['store_id'])) {
            throw new \Exception('store_id not founded in line ' . $index);
        }

        if ($this->categoryRepository->exists('name', $row['category'])) {
            throw new \Exception('category name already exists in line ' . $index);
        }
    }

    /**
     * @param array $row
     * @return array
     */
    private function createCategory(array $row)
    {
        $category = $this->categoryRepository->create([
            'name' => $row['name']
        ]);

        $row['category_id'] = $category->getKey();

        unset($row['category']);

        return $row;

    }

    /**
     * @param $data
     */
    private function persistRow($data)
    {
        $this->products[] = $this->productRepository->create($data);
    }


}
