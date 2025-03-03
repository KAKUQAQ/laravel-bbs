@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        Edit Topic
                    </h2>
                    <hr>
                    <form action="{{ route('topics.edit') }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @include('shared._error')
                        <div class="mb-3">
                            <label for="title"></label>
                            <input class="form-control" type="text" id="title" value="{{ old('title', $topic->title) }}" placeholder="Place for title" required/>
                        </div>
                        <div class="mb-3">
                            <label for="category_id"></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="" hidden disabled selected>Please Select a Category</option>
                                @foreach($categories as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editor"></label>
                            <textarea name="body" class="form-control" id="editor" rows="6" placeholder="Enter your Post in at least 3 characters" required>{{ old('body', $topic->body) }}</textarea>
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">
                                <i class="far fa-save mr-2" aria-hidden="true"></i>
                                Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
