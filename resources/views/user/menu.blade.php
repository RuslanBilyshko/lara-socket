<nav class="menu user-menu">
    <ul>
        @foreach($menu as $item)
            <li>
                <a class="btn btn-{{$item['class']}} btn-sm"  href="{{$item['link']}}">
                    @if(isset($item['icon']))
                    <i class="fa fa-{{$item['icon']}}" aria-hidden="true"></i>
                    @endif
                    {{$item['title']}}
                </a>
            </li>
        @endforeach
    </ul>
</nav>