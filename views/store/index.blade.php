@extends('template', ['title' => 'Stores'])

@section('content')

    <div class="pt-5">

        <h1 class="pb-2">Stores</h1>

        <div class="row">
            <div class="col-8">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success" href="/new">New</a>
                    <button type="button" class="btn btn-secondary">Import</button>
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
                @if(count($stores) > 0)

                    @foreach($stores as $store)
                    <tr>
                        <td>{{ $store->getKey() }}</td>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->address }}</td>
                        <td class="actions">
                            <a class="btn btn-success btn-xs" href="/edit/{{ $store->getKey() }}">edit</a>
                            <a class="btn btn-danger btn-xs"  href="#" data-toggle="modal" data-target="#delete-modal">delete</a>
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

    <!-- Modal -->
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
                    <button type="button" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

@endsection
