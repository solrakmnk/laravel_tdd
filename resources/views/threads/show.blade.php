@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}</div>

                    <div class="card-body">
                            <article>
                                <div class="body">{{$thread->body}}</div>
                            </article>
                            <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach

            </div>
        </div>
        @if(auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{$thread->path().'/replies'}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="body">Reply</label>
                        <textarea name="body" id="body" rows="5" class="form-control" placeholder="Write something"></textarea>
                    </div>
                    <button class="btn btn-defult"type="submit">Submit</button>
                </form>
            </div>
        </div>
            @else
            <div class="col-md-8">
                <p class="text-center"><a href="{{route('login')}}">Please login</a></p>
            </div>
            @endif
    </div>
@endsection
