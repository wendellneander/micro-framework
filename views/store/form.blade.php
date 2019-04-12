@extends('template')

@section('content')
    <div class="pt-5">

        <h1 class="pb-2">{{ $store ? 'Edit' : 'New' }} Store</h1>

        <form method="post" action="{{ $store ? '/update/' . $store->getKey() : '/save' }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input required type="text" class="form-control"
                       id="name" name="name" value="{{ $store ? $store->name : '' }}">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input required type="text" class="form-control"
                       id="address" name="address" value="{{ $store ? $store->address : '' }}">
            </div>

            <button type="submit" class="btn btn-primary mb-2">Save</button>

            @if($store)
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#delete-modal">delete</button>
            @endif

        </form>

    </div>

    @if($store)
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
                        <a type="button" class="btn btn-primary" href="/delete/{{ $store->getKey() }}">Yes</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
