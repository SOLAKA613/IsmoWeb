<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="header_img"> <img src="{{ asset('storage/posts/post3.jpg')}}" alt=""> </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <i class='bx bx-layer nav_logo-icon'></i>
                <span class="nav_logo-name">ISMO</span>
            </a>
                {{ menu('myMenu', 'partials.nav') }}

        </div>
    </nav>
</div>
