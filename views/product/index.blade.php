@extends('template', ['title' => 'Products'])

@section('content')

    <div class="pt-5">

        <h1 class="pb-2">Products</h1>

        <div class="row">
            <div class="col-8">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success" href="/product/new">New</a>
                    <button type="button" class="btn btn-secondary">Import</button>
                    <a type="button" class="btn btn-primary" href="/">See Stores</a>
                </div>
            </div>
            <div class="col-4">
                <form class="form-inline" method="get">
                    <div class="form-group mx-sm-3 mb-2">
                        <input value="{{ $search ?? '' }}" name="q" type="text" class="form-control" id="search" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </form>
            </div>
        </div>

        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($products) > 0)

                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->getKey() }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2, '.', ',') }}</td>
                        <td class="actions">
                            <a class="btn btn-success btn-xs" href="/product/edit/{{ $product->getKey() }}">edit</a>
                            <button class="btn btn-danger btn-xs" onclick="setProduct({{ $product->getKey() }})"
                               data-toggle="modal" data-target="#delete-modal">delete</button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Nothing here</td>
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
