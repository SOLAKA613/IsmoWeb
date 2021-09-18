

<style>
    .icon{
        margin-right:7px;
        text-decoration: underline;
    }
    .icon:hover {
        color: rgb(255, 255, 255);
    }
    .nav-link{
        margin-left:8px;
    }

    .nav_name{
        color: #afa5d9;
        text-decoration: underline;
    }
</style>

<div class="nav_list">

    @foreach ($items as $item)

        <a href="{{ $item->url }}" class="nav-link" target="{{ $item->target }}">
            <i class="icon {{ $item->icon_class }} nav_icon" style="color: {{ $item->color }}"></i>
            <span class="nav_name" style="color: {{ $item->color }}">{{ $item->title}}</span>
        </a>

    @endforeach

    <a href="/" class="nav_link">
        <i class='icon bx bx-log-out nav_icon'></i>
        <span class="nav_name">SignOut</span>
    </a>


</div>
