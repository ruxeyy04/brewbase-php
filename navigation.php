<?php 

$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];
?>
    <div class="loader-wrapper">
        <svg class="tea" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="var(--secondary)" stroke-width="2"></path>
            <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="var(--secondary)" stroke-width="2"></path>
            <path id="teabag" fill="var(--secondary)" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
            <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="var(--secondary)"></path>
            <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </div>
<header id="masthead" class="site-header">
        <nav id="primary-navigation" class="site-navigation">
            <div class="container">

                <div class="navbar-header">
                   
                    <a class="site-title"><span>Brew</span>Base</a>

                </div>

                <div class="collapse navbar-collapse">
                    <ul id="nav" class="nav navbar-nav navbar-right">

                        <li <?=$first_part == '' ? 'class="active"' : '' ;?>><a href="/">Home</a></li>
                        <li class="dropdown  <?=$first_part == 'about' || $first_part == 'concern' ? 'active' : '' ;?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown">About<i class="fa fa-caret-down hidden-xs" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">

                            <li><a href="/about/">About Us</a></li>
                            <li><a href="/concern/">Have Concerns?</a></li>
                            </ul>
                        </li>
                        <?php if(isset($_SESSION['username'])) {
                            if($_SESSION['usertype'] != "Customer") {?>
                        <li class="dropdown  <?=$first_part == 'admin' || $first_part == 'incharge'? 'active' : '' ;?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['usertype'] == 'Admin' ? 'Admin' : 'In-charge' ;?><i class="fa fa-caret-down hidden-xs" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                <?php if($_SESSION['usertype'] == 'Admin') {?>
                            <li><a href="/admin/product/">Manage Product/Menu</a></li>
                            <li><a href="/admin/user/">Manage User</a></li>
                            <li><a href="/admin/order/">Manage Order</a></li>
                            <li><a href="/admin/transactions">View All Transaction</a></li>
                            <?php } else {?>
                            <li><a href="/incharge/product/">Manage Product/Menu</a></li>
                            <li><a href="/incharge/order/">Manage Order</a></li>
                                <?php }?>
                            </ul>
                        </li>
                        <?php }
                    } ?>
                        <li  <?=$first_part == 'product' ? 'class="active"' : '' ;?>><a href="/product/">Product</a></li>
                        <?php if(!isset($_SESSION['username'])) {?>
                        <li <?=$first_part == 'login' ? 'class="active"' : '' ;?> ><a href="/login/">Login</a></li>
                        <?php } ?>
                        <?php if(isset($_SESSION['username'])) {?>
                        <li class="dropdown  <?=$first_part == 'profile' || $first_part == 'purchase' ? 'active' : '' ;?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<i class="fa fa-caret-down hidden-xs" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li><a href="#">User: <?=$_SESSION['username'] ?></a></li>
                            <li><a href="/purchase/">My Purchase</a></li>
                            <li><a href="/profile/">My Profile</a></li>
                            <li><a href="?logout">Logout</a></li>
                            
                            </ul>
                        </li>
                        <?php } ?>
                        <li>
                            <form action="/product/" method="get">
                            <div class="search-box">
                            <input class="search-txt"  name="search" placeholder="Type to search">
                            <button class="search-btn"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                        </li>
                        </ul>
                    </ul>

                </div>

            </div>   
        </nav>
    </header>