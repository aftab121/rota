<!--  preloader start -->
<div id="tb-preloader">
    <div class="tb-preloader-wave"></div>
</div>
<!-- preloader end -->
<div class="wrapper">
    <!--header start-->
    <header class="l-header">
        <div class="l-navbar l-navbar_expand l-navbar_t-light js-navbar-sticky">
            <div class="container-fluid">
                <nav class="menuzord js-primary-navigation" role="navigation" aria-label="Primary Navigation">
                    <!--logo start-->
                    <a href="{{URL('/')}}" class="logo-brand">
                        <img class="retina" src="{{asset('img/logo.png')}}" alt="Massive">
                    </a>
                    <!--logo end-->
                    <!--mega menu start-->
                    <ul class="menuzord-menu menuzord-right c-nav_s-standard">
                        <li class="active"><a href="#">This Season</a>
                            <ul class="dropdown">
                                <li>
                                    <a href="{{URL('NowPlaying')}}">Now Playing</a>
                                </li>
                                <li><a href="#">Coming Soon</a> </li>
                                <li><a href="#">55th Winter Season</a></li>
                                <li><a href="#">55th Fall Season</a></li>
                                <li><a href="#">La Galleria</a></li>
                                <li><a href="#">Past Seasons</a>
                                
                                <ul class="dropdown">
                                    <li><a href="#">54th Season</a> </li>
                                    <li><a href="#">53rd Season</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <li><a href="#">Tickets</a>
                <ul class="dropdown">
                    <li><a href="#">TEN @ $10</a> </li>
                    <li><a href="#">Satoris Gift Cards</a> </li>
                    <li><a href="#">Satoris Memberships</a></li>
                    
                </ul>
            </li>
            
            <li><a href="#">Programs</a>
            <ul class="dropdown">
                <li><a href="#">Archives</a> </li>
                <li><a href="#">Coffeehouse Chronicles</a> </li>
                <li><a href="#">CultureHub</a></li>
                <li><a href="#">Experiments Play Reading Series</a></li>
                <li><a href="#">La Galleria</a></li>
                <li><a href="#">Satoris Kids</a></li>
                <li><a href="#">Satoris Moves</a></li>
                <li><a href="#">Satoris&#8217;s Squirts</a></li>
                <li><a href="#">Satoris Umbria International</a></li>
                <li><a href="#">Meet-Ups</a></li>
                <li><a href="#">Poetry Electric</a></li>
                <li><a href="#">Puppet Series</a></li>
                <li><a href="#">Safe Harbors Indigenous Collective</a></li>
                <li><a href="#">Student Programs</a></li>
                <li><a href="#">The Sixth Annual American Human Beatbox Festival</a></li>
                <li><a href="#">The Trojan Women Project</a></li>
            </ul>
        </li>
        <li><a href="#">About</a>
        <ul class="dropdown">
            <li><a href="#">Mission and History</a> </li>
            <li><a href="#">Board and Staff</a> </li>
            <li><a href="#">Junior Committee</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Satoris Campus</a></li>
        </ul>
    </li>
    <li><a href="#">Support US</a>
    <ul class="dropdown">
        <li><a href="#">Our Founders</a> </li>
    </ul>
</li>
<li><a href="#">Rentals</a>
<ul class="dropdown">
    <li><a href="#">Rehearsal Studios</a> </li>
    <li> <a href="{{ URL('TheatreRental')}}" >Theater Rentals</a> </li>
</ul>
</li>
<li> <a href="{{ URL('Blog')}}">Blog</a> </li>
<?php if(Session::has('User')){?><li> <a href="{{ URL('Logout')}}">Logout</a> </li><?php } else{?><li> <a href="{{ URL('Login')}}">Member Login</a> </li><?php } ?>
</ul>
</nav>
</div>
</div>
</header>
</div><!--header end-->