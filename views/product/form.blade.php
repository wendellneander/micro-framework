@extends('template')

@section('content')
    <div class="pt-5">

        <h1 class="pb-2">{{ isset($product) && $product ? 'Edit' : 'New' }} Product</h1>

        <form method="post" action="{{ isset($product) && $product ? '/product/update/' . $product->getKey() : '/product/save' }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input required type="text" class="form-control"
                       id="name" name="name" value="{{ isset($product) && $product ? $product->name : '' }}">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input required type="text" class="form-control money"
                       id="price" name="price" value="{{ isset($product) && $product ? $product->price : '' }}">
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select required class="form-control" name="category_id" id="category_id">
                    <option disabled>Select</option>
                    @foreach($categories as $category)
                        <option {{ isset($product) && $product && $category->getKey() == $product->category_id ? 'selected' : '' }}
                                value="{{ $category->getKey() }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="store_id">Store</label>
                <select required class="form-control" name="store_id" id="store_id">
                    <option disabled>Select</option>
                    @foreach($stores as $store)
                        <option {{ isset($product) && $product && $store->getKey() == $product->store_id ? 'selected' : '' }}
                                value="{{ $store->getKey() }}">
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Save</button>

            @if(isset($product) && $product)
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#delete-modal">Delete</button>
            @endif

        </form>

    </div>

    @if(isset($product) && $product)
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
                        <a type="button" class="btn btn-primary" href="/product/delete/{{ $product->getKey() }}">Yes</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('js')
    <script src="/assets/jquery.js"></script>
    <script src="/assets/jquery.mask.min.js"></script>
    <script>
        $('.money').mask('000000.00', {reverse: true});
    </script>
@endpush
