<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Layout</title>
    <link rel="stylesheet" href="/packages/bootstrap/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="/packages/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/css/food.css" media="screen">
    @yield('css')
</head>
<body>
    <div class="container">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <a class="brand" href="/">Food DB</a>
                <ul class="nav">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-table"></i>&nbsp;&nbsp;Tables&nbsp;
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            {{ ApiController::getApiLinks() }}
                        </ul>
                    </div>
                </ul>
            </div><!-- .navbar-inner -->
        </div><!-- .navbar .navbar-fixed-top -->        

        <div class="row">        
            {{-- This is where the actual page content will go--}}
            <div class="content span12">
                @yield('content')
            </div>
        </div> <!--  .row -->
    </div> <!-- end .container -->

    <div id="footer">
    </div> <!-- end footer -->

<script src="/packages/jquery/jquery.js"></script>
<script src="/packages/jquery-ui/jquery-ui-built.js"></script>
<script src="/packages/bootstrap/js/bootstrap.js"></script>
@yield('js')

</body>
</html>
