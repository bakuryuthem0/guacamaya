<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $title; }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::style("css/normalize.css") }}
        {{ HTML::style("css/main.css") }}
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-theme.min.css') }}
        {{ HTML::script("js/vendor/modernizr-2.6.2.min.js") }}
        {{ HTML::style('css/custom.css') }}
        {{ HTML::style('js/slick/slick.css') }}
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default" style="position:initial;">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="col-xs-1">
                  <a href="{{ URL::to('administrador/inicio') }}"><img src="{{ asset('images/logo2.jpg') }}" class="logo2"></a>
                </div>

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
               
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1 col-xs-3">
                @if(!Auth::check())
                <h3 style="text-align:right;vertical-align:middle;">Sistema de administracion de guacamayastores</h3>
                @else
                  <ul class="nav navbar-nav">
                      <li class="dropdown myMenu">
                        <a href="#" class="dropdown-toggle textoPromedio" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-user"></i>
                            {{ Auth::user()->username }}
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level" role="menu">
                            <li class="dropdown-submenu">
                              <a href="#" >
                                Categorías
                              </a>
                              <ul class="dropdown-menu" role="menu">
                                <li>
                                  <a href="{{ URL::to('categoria/nueva') }}">
                                    <i class="fa fa-plus"></i> Nueva categoría
                                  </a>
                                </li>
                                <li>
                                  <a href="{{ URL::to('categoria/ver-categorias') }}">
                                    
                                    Modificar categoría
                                  </a>
                                </li>
                                <li>
                                  <a href="{{ URL::to('categoria/nueva-sub-categoria') }}">
                                    Nueva Sub-categoría
                                  </a>
                                </li>
                                <li>
                                  <a href="{{ URL::to('sub-categoria/ver-sub-categorias') }}">
                                    Modificar Sub-categoría
                                  </a>
                                </li>
                              </ul>
                            </li>
                            <li class="dropdown-submenu">
                              <a href="#" >
                                Colores
                              </a>
                              <ul class="dropdown-menu" role="menu">
                                <li>
                                  <a href="{{ URL::to('color/nuevo') }}">
                                    <i class="fa fa-plus"></i> Nuevo
                                  </a>
                                </li>
                                <li>
                                  <a href="{{ URL::to('colores/ver-colores') }}">
                                    <i class="fa fa-money"></i>
                                    Modificar
                                  </a>
                                </li>
                              </ul>
                            </li>
                            <li class="dropdown-submenu">
                              <a href="#" >
                                Articulos
                              </a>
                              <ul class="dropdown-menu" role="menu">
                                <li>
                                  <a href="{{ URL::to('administrador/nuevo-articulo') }}">
                                    Nuevo articulo
                                  </a>
                                </li>
                                <li>
                                  <a href="{{ URL::to('administrador/ver-articulo') }}">
                                    Ver articulos
                                  </a>
                                </li>
                              </ul>
                            </li>
                            
                          </ul>
                        </li>
                      <li class="textoPromedio"><a href="{{ URL::to('cerrar-sesion') }}">Cerrar sesión</a></li>
                  </ul>
                @endif

                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                  </form>
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                  
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>--><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
        </header>
    @yield('content')
    {{ HTML::script("http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js") }}
        <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script("js/plugins.js") }}
        {{ HTML::script("js/main.js") }}
        {{ HTML::script('js/slick/slick.min.js') }}
        {{ HTML::script('js/custom.js') }}
        {{ HTML::script('js/ckeditor.js') }}
        {{ HTML::script('js/jquery.ckeditor.js') }}
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-57229555-1', 'auto');
          ga('send', 'pageview');

        </script>
        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='//v2.zopim.com/?2qPOZqZ2IaypF8Jd7TLchBaYy0CjQwsP';z.t=+new Date;$.
        type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
        </script>
        <!--End of Zopim Live Chat Script-->
       @yield('postscript')
    </body>
</html>