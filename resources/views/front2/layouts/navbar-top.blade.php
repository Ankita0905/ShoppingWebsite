<header class="header-style-1">
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 logo-holder">
                    <div class="logo">
                        <span style="font-size:24px;font-weight:bold; color:#d0205e;">Tech Tribe Electronic Store</span>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-8 animate-dropdown top-cart-row">
                    <div class="dropdown dropdown-cart">
                        <a href="{!! route('front.cart') !!}" class="dropdown-toggle lnk-cart">
                            <div class="items-cart-inner">
                                <div class="basket"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                                <div class="basket-item-count"><span class="count">{!! cartCount() !!}</span></div>
                                <div class="total-price-basket">
                                    <span class="lbl">Cart -</span>
                                    <span class="value">${!! cartTotal() !!}</span> </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button"><span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                <li><a href="{!! route('front') !!}">Home</a></li>
                                <li><a href="{!! route('front.contact-us') !!}">Contact Us</a></li>
                                @if(\Auth::check())
                                    <li><a href="{!! route('front.order-list') !!}">Order History</a></li>
                                    <li><a href="{!! route('front.logout') !!}">Logout</a></li>
                                @else
                                    <li><a href="{!! route('front.login') !!}">Sign In</a></li>
                                @endif
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
     