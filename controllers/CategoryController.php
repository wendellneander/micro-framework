<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:22
 */

namespace Controllers;

use Core\Controller;
use Core\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Repository\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $params = $request->all();

        $search = $params['q'];

        $categories = $this->categoryRepository->searchByName($search);

        $this->view('category/index', ['categories' => $categories, 'search' => $search]);
    }

    public function create()
    {
        $this->view('category/form');
    }

    public function edit(int $id)
    {
        try {
            $category = $this->categoryRepository->show($id);

            $this->view('category/form', ['category' => $category]);
        } catch (ModelNotFoundException $exception) {
            Request::redirect('/category');
        }

    }

    public function save(Request $request)
    {
        $this->categoryRepository->create($request->all());

        Request::redirect('/category');
    }

    public function update(Request $request, int $id)
    {
        try {
            $this->categoryRepository->update($request->all(), $id);

            Request::redirect('/');
        } catch (ModelNotFoundException $exception) {
            Request::redirect('/category');
        }
    }

    public function delete(int $id)
    {
        $this->categoryRepository->delete($id);

        Request::redirect('/category');
    }

}
