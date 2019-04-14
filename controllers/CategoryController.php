<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Session;
use Core\Validator;
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

        $search = isset($params['q']) && $params['q'] ? $params['q'] : null;

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
        } catch (\Exception $exception) {

            Session::flash('message', $exception->getMessage());

            Request::redirect('/categories');
        }

    }

    public function save(Request $request)
    {
        try{

            $data = $request->all();

            Validator::getInstance()->validate($data,[
                'name' => 'string|required',
            ]);

            $this->categoryRepository->create($request->all());
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());
        }


        Request::redirect('/categories');
    }

    public function update(Request $request, int $id)
    {
        try {
            $data = $request->all();

            Validator::getInstance()->validate($data, [
                'name' => 'string',
            ]);

            $this->categoryRepository->update($request->all(), $id);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());
        }

        Request::redirect('/categories');
    }

    public function delete(int $id)
    {
        $this->categoryRepository->delete($id);

        Request::redirect('/categories');
    }

}
