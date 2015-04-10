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
        {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') }}
        <script>
            window.fbAsyncInit = function() {
              FB.init({
                appId      : '1640851839462151',
                xfbml      : true,
                version    : 'v2.3'
              });
            };

            (function(d, s, id){
               var js, fjs = d.getElementsByTagName(s)[0];
               if (d.getElementById(id)) {return;}
               js = d.createElement(s); js.id = id;
               js.src = "//connect.facebook.net/en_US/sdk.js";
               fjs.parentNode.insertBefore(js, fjs);
             }(document, 'script', 'facebook-jssdk'));
          </script>
    </head>
    <body id="body">
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="col-xs-3">
                  <a href="{{ URL::to('inicio') }}"><img src="{{ asset('images/logo.png') }}" class="logo"></a>
                </div>

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
                <div class="col-xs-6 myBuscador">
                  <form method="POST" action="{{ URL::to('busqueda') }}">
                    <div class="input-group-btn">
                      <button type="button" class="btn dropdown-toggle btn-buscar-cat" data-toggle="dropdown" aria-expanded="false">Categorias <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                        {{ ShowCat::show() }}
                      </ul>
                    </div><!-- /btn-group -->
                     <input class="form-control inputBusqueda" placeholder="Busqueda por palabras claves,marcas o productos" name="busq">
                    <button class="btn bt-buscar"><i class="fa fa-search"></i></button>
                 
                  
                  </form>
                </div>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="display:inline-block !important;">
                <table class="nav navbar-nav table table-striped table-hover textoPromedio nav navbar-nav">
                   @if(!Auth::check())
                    <tr>
                      <td style="text-align:center;"><a href="{{ URL::to('iniciar-sesion') }}">Iniciar sesión</a></td>
                    </tr>
                    <tr>
                      <td style="text-align:center;"><a href="{{ URL::to('registro') }}">Registrarse </a></td>
                    </tr>
                    <tr>
                      <td style="text-align:center;"><a href="{{ URL::to('contactenos') }}">Contactenos</a></td>
                    </tr>
                  @else
                    <tr>
                      <td class="dropdown" style="text-align:center;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-user"></i>
                            {{ Auth::user()->username }}
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu multi-level" role="menu">
                          <li>
                            <a href="{{ URL::to('usuario/perfil') }}">
                              <span class="fa fa-cog"></span> Perfil
                            </a>
                          </li>
                          <li>
                            <a href="{{ URL::to('usuario/mis-compras') }}">
                              Mis compras
                            </a>
                          </li>
                          <li>
                            <a href="{{ URL::to('cerrar-sesion') }}">
                              <i class="fa fa-sign-out"></i> Cerrar sesión
                            </a>
                          </li>
                        </ul>
                      </td>
                    </tr>
                    <tr data-toggle="collapse" href="#contCarrito" id="carrito">
                      <td style="text-align:center;">  
                         <label style="cursor:pointer;"><i class="fa fa-shopping-cart"></i> Cantidad de artículos: <span class="catnArt">{{ Cart::count() }}</span></label>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center;">
                        <label><i class="fa fa-money"></i> Total: Bs.<span class="total">{{ Cart::total() }} </span><a type="button" class="btn btn-success btn-xs @if(Cart::count()>0) btn-comprar @else btn-no @endif" href="{{ URL::to('comprar/ver-carrito') }}">Comprar</a></label>
                      </td>
                    </tr>
                  @endif
                </table>
              </div>
            </div>
               
              <div class="miniBanner" style="text-align:center;"><p class="textoPromedio" style="color:white;padding-top:1em">Envios gratis a toda venezuela.</p></div>
            </nav>
        <div id="contCarrito">
          <div class="table-responsive">
            <table class="table table-hover tableCarrito">
               <tr>
                  <th>
                   Imagen
                  </th>
                  <th>
                   Artículo
                  </th>
                  <th>
                    Cantidad
                  </th>
                  <th>
                    Precio Unitario
                  </th>
                  <th>
                    Sub-total
                  </th>
                   <th>
                    Agregar
                  </th>
                   <th>
                    Restar
                  </th>
                  <th>
                    <button class="btn btn-danger btn-xs btnVaciar">
                      Vaciar
                    </button>
                  </th>
                </tr>
              @foreach(Cart::content() as $cart)
                <tr class="carItems" id="{{ $cart->id }}">
                  <td class="carItem">
                    <img src="{{ asset('images/items/'.$cart->options['img']) }}" class="carImg">
                  </td>
                  <td class="carItem">
                    {{ $cart->name }}
                  </td>
                  <td class="carItem">
                    {{ $cart->qty }}
                  </td>
                  <td class="carItem">
                    {{ $cart->price }}
                  </td>
                  <td class="carItem">
                    {{ $cart->subtotal }}
                  </td>
                  <th class="carItem">
                    <button class="btn btn-success btn-xs btnAdd btn-carrito" data-url-value="agregar-item" value="{{ $cart->rowid }}">
                      Agregar
                    </button>
                  </th>
                  <th class="carItem">
                    <button class="btn btn-warning btn-xs btnRestar btn-carrito" data-url-value="restar-item" value="{{ $cart->rowid }}">
                      Restar
                    </button>
                  </th>
                  <th class="carItem">
                    <button class="btn btn-danger btn-xs btnQuitar btn-carrito" data-url-value="quitar-item" value="{{ $cart->rowid }}">
                      Quitar
                    </button>
                  </th>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
        @yield('content')
        <footer>
          <div class="col-xs-9 contFoot">
              <div class="col-xs-12 contList contCentrado">
                <div class="col-xs-6 textoPromedio">
                  <label>Acerca de guacamaya</label>
                  <ul class="ulNoStyle">
                    <li><a href="{{ URL::to('') }}" class="aConFormato">Quiénes somos</a></li>
                    <li><a href="{{ URL::to('') }}" class="aConFormato">Términos y Condiciones</a></li>
                    <li><a href="{{ URL::to('') }}" class="aConFormato">Cupones y Códigos de Promoción</a></li>
                    <li><a href="{{ URL::to('') }}" class="aConFormato">Politicas de protección de datos</a></li>
                    <li><a href="{{ URL::to('') }}" class="aConFormato">Formas de pago</a></li>
                    <li>
                      <a href="{{ URL::to('contactenos') }}" class="aConFormato">
                        Contacto
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="col-xs-6 contRedes">
                  <i class="fa fa-facebook redes" id="facebook"></i>
                  <i class="fa fa-twitter redes"></i>
                  <i class="fa fa-instagram redes"></i>
                  <i class="fa fa-google-plus redes"></i>
                </div>
                <div class="clearfix"></div>
              </div>
          </div>
            <div class="col-xs-12 footerTerm">
              <p class="textoPromedio"><i class="fa fa-copyright"></i> 2015 Guacamaya stores 2015, c.a. | Todos los derechos reservados. Desarrolado por <a href="{{ URL::to('http://tecnographic.com.ve') }}" target="_blank">Tecnographic Venezuela c.a.</a></p>
            </div>
        </footer>
        {{ HTML::script("http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js") }}
        <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script("js/plugins.js") }}
        {{ HTML::script("js/main.js") }}
        {{ HTML::script('js/slick/slick.min.js') }}
        {{ HTML::script('js/custom.js') }}
        {{ HTML::script('js/jquery.elevateZoom-3.0.8.min.js') }}
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