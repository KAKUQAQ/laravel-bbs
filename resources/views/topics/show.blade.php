@extends('layouts.app')

@section('title', $topic->title)

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        Author: {{ $topic->user->name }}
                    </div>
                    <hr>
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show', $topic->user->id) }}">
                                <img src="{{ $topic->user->avatar }}" class="thumbnail img-fluid" width="300px" height="300px" alt="user's avatar">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $topic->title }}
                    </h1>
                    <div class="article-meta text-center text-secondary">
                        {{ $topic->created_at->diffForHumans() }}
                        ·
                        <i class="far fa-comment"></i>
                        {{ $topic->reply_count }}
                    </div>
                    <div class="topic-body mt-4 mb-4">
                        {!! $topic->body !!}
                    </div>
                    <div class="operate">
                        <hr>
                        <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                            <i class="far fa-edit"></i>Edit
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm" role="button">
                            <i class="far fa-trash-alt"></i>Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
