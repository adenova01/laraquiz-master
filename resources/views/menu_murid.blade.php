<ul class="nav navbar-nav">
    @foreach ($items as $menu_item)
    <li  class="classes">
        <a target="{{ $menu_item->target }}" href="{{ $menu_item->link() }}" style="{{ $menu_item->color }}">
            <span class="icon{{$menu_item->icon_class}}"></span>
            <span class="title">{{ $menu_item->title}}</span>
        </a>
    </li>
    @endforeach
</ul>