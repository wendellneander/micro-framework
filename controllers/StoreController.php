<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Session;
use Repository\StoreRepository;

class StoreController extends Controller
{
    /**
     * @var StoreRepository
     */
    private $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function index(Request $request)
    {
        $params = $request->all();

        $search = isset($params['q']) && $params['q'] ? $params['q'] : null;

        $stores = $this->storeRepository->searchByName($search);

        $this->view('store/index', ['stores' => $stores, 'search' => $search]);
    }

    public function create()
    {
        $this->view('store/form');
    }

    public function edit(int $id)
    {
        try {
            $store = $this->storeRepository->show($id);

            $this->view('store/form', ['store' => $store]);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());

            Request::redirect('/');
        }

    }

    public function save(Request $request)
    {
        try {
            $this->storeRepository->create($request->all());
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());
        }

        Request::redirect('/');
    }

    public function update(Request $request, int $id)
    {
        try {
            $this->storeRepository->update($request->all(), $id);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());
        }

        Request::redirect('/');
    }

    public function delete(int $id)
    {
        $this->storeRepository->delete($id);

        Request::redirect('/');
    }

}
