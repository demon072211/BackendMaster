<div class="card-header p-0 pt-1 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if($params['type']== 'MINIGAME') {{'active'}} @endif" href="{{route('game', ['type' => 'MINIGAME'])}}">Mini game</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($params['type']== 'POKER') {{'active'}} @endif" href="{{route('game', ['type' => 'POKER'])}}">Poker</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($params['type']== 'LIVECASINO') {{'active'}} @endif" href="{{route('game', ['type' => 'LIVECASINO'])}}">Live casino</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($params['type']== 'SPORT') {{'active'}} @endif" href="{{route('game', ['type' => 'SPORT'])}}">Sport</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($params['type']== 'NOHU') {{'active'}} @endif" href="{{route('game', ['type' => 'NOHU'])}}">Nổ hũ</a>
        </li>
    </ul>
</div>