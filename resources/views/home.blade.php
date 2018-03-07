@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        <li><a href="/vultr">vultr 管理</a></li>
                        <li><a href="/logs">日志</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
