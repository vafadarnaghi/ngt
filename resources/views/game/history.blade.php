@extends('layout.default')

@section('content')
    <div class="row">
    @include('layout.form')
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Outcome</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($latestResults as $i => $result)
            <tr>
                <th scope="row">{{ $i + 1 }}</th>
                <td>{{ $result->outcome->label() }}</td>
                <td>{{ $result->amount }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
