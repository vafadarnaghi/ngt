@extends('layout.default')

@section('content')
    <div class="row">
        @include('layout.form')
        @include('layout.history-link')
    </div>
    <div class="row text-center m-5">
        <div class="col">
            <h1>Outcome: {{ $result->outcome->label() }}</h1>
            <h1>Amount: {{ $result->amount }}</h1>
        </div>
    </div>
@endsection
