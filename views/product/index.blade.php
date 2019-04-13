@extends('template', ['title' => 'Products'])

@section('content')

    <div class="pt-5">

        <h1 class="pb-2">Products</h1>

        <div class="row">
            <div class="col-6">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success" href="/product/new">New</a>
                    <button type="button" class="btn btn-secondary"
                            data-toggle="modal" data-target="#import-modal">Import</button>
                </div>
            </div>
            <div class="col-6">
                <form class="form-inline" method="get">
                    <div class="form-group mb-2">
                        <select class="form-control" name="category" id="category">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option {{ isset($category_id) && $category_id == $category->getKey() ? 'selected' : '' }}
                                        value="{{ $category->getKey() }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input value="{{ $search ?? '' }}" name="q" type="text" class="form-control" id="search" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Apply</button>
                </form>
            </div>
        </div>

        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Category</th>
                    <th>Store</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($stores) > 0)

                    @foreach($stores as $store)
                        <tr>
                            <td><strong>{{ $store->name }}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($store->products as $product)
                            <tr>
                                <td></td>
                                <td>{{ $product->name }}</td>
                                <td>$ {{ $product->price }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->store->name }}</td>
                                <td class="actions">
                                    <a class="btn btn-success btn-xs" href="/product/edit/{{ $product->getKey() }}">edit</a>
                                    <button class="btn btn-danger btn-xs" onclick="setProduct({{ $product->getKey() }})"
                                       data-toggle="modal" data-target="#delete-modal">delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td>Nothing here</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Delete Item</h4>
                </div>
                <div class="modal-body">
                    Do you really want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="deleteProduct()">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/product/import" enctype="multipart/form-data" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Import Products</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                   name="file" type="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        let selectedProductId = null

        let setProduct = (id) => selectedProductId = id

        let deleteProduct = () => {
            if(!selectedProductId){
                return;
            }

            window.location.href = '/product/delete/' + selectedProductId
        }
    </script>
@endpush
