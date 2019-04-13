@extends('template', ['title' => 'Categories'])

@section('content')

    <div class="pt-5">

        <h1 class="pb-2">Categories</h1>

        <div class="row">
            <div class="col-8">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success" href="/category/new">New</a>
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
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($categories) > 0)

                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->getKey() }}</td>
                        <td>{{ $category->name }}</td>
                        <td class="actions">
                            <a class="btn btn-success btn-xs" href="/category/edit/{{ $category->getKey() }}">edit</a>
                            <button class="btn btn-danger btn-xs" onclick="setCategory({{ $category->getKey() }})"
                               data-toggle="modal" data-target="#delete-modal">delete</button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Nothing here</td>
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
                    <button type="button" class="btn btn-primary" onclick="deleteCategory()">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        let selectedCategoryId = null

        let setCategory = (id) => selectedCategoryId = id

        let deleteCategory = () => {
            if(!selectedCategoryId){
                return;
            }

            window.location.href = '/category/delete/' + selectedCategoryId
        }
    </script>
@endpush
