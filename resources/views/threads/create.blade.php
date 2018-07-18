@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create new Thread</div>

                    <div class="card-body">
                        <form method="post" action="/threads">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" placeholder="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea id="body" name="body" placeholder="body" rows="8" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="sumbit" class="btn btn-primary">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
