@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                        <h3><a href="/todos">Visit Todos</a></h3>
                        <form action="{{route('testing',[5,'elyes','informatique'])}}" method="post">
                            @csrf
                            @method('post')
                            <button class="btn btn-success" value="submit">Post Parameters</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
