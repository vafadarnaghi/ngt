<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>game app</title>
    </head>
    <body>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="users/register">
            @csrf
            <label>Name:</label>
            <input type="text" name="name" />
            <label>Phone number:</label>
            <input type="text" name="phone_number" />
            <input type="submit" value="Register">
        </form>
    </body>
</html>
