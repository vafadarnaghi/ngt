<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Game App</title>
    </head>
    <body>
        <div>
            <form method="post" action="{{ route('play', $accessToken) }}">
                @csrf
                <input type="submit" name="submit" value="I feel lucky">
            </form>
            <form method="POST" action="{{ route('deactivate', $accessToken) }}">
                @csrf
                @method('DELETE')
                <input type="submit" name="submit" value="Deactivate">
            </form>
            <form method="post" action="{{ route('createGame', $accessToken) }}">
                @csrf
                <input type="submit" name="submit" value="Create new game">
            </form>
        </div>
        <div>
            @foreach ($latestResults as $result)
                <p>Outcome: {{ $result->outcome->label() }} | Amount: {{ $result->amount }}</p>
            @endforeach
        </div>
    </body>
</html>
