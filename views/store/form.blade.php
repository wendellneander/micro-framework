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

        </form>

    </div>
@endsection
