@extends('layout.default')

@section('content')
    <div class="col-4">
        @if ($errors->any())
        <div class="row alert alert-danger m-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <form method="POST" action="users/register">
                @csrf
                <div class="form-group m-2">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" />
                </div>
                <div class="form-group m-2">
                    <label class="form-label">Phone number:</label>
                    <input type="text" name="phone_number" class="form-control"/>
                </div>
                <button type="submit" class="btn btn-primary m-2">Register</button>
            </form>
        </div>
    </div>
@endsection
