<div class="col">
    <form method="post" action="{{ route('game.play', $accessToken) }}">
        @csrf
        <button type="submit" class="btn btn-success m-2">I am feeling lucky</button>
    </form>
</div>
<div class="col">
    <form method="POST" action="{{ route('game.deactivate', $accessToken) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger m-2">Deactivate</button>
    </form>
</div>
<div class="col">
    <form method="post" action="{{ route('game.create', $accessToken) }}" target="_blank">
        @csrf
        <button type="submit" class="btn btn-primary m-2">Create new game</button>
    </form>
</div>

