@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">编辑一篇文章</div>
                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>编辑失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/articles/edit') }}" method="POST">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $article->id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="title" class="form-control" required="required" value="{{ $article->title }}">
                        <br>
                        <textarea name="body" rows="10" class="form-control" required="required" >{{ $article->body }}</textarea>
                        <br>
                        <button class="btn btn-lg btn-info">编辑文章</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection