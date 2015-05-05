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
        <link rel="icon" type="image/jpg" href="{{ asset('images/favicon.jpg') }}" />
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::style("css/normalize.css") }}
        {{ HTML::style("css/main.css") }}
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-theme.min.css') }}
        {{ HTML::script("js/vendor/modernizr-2.6.2.min.js") }}
        {{ HTML::style('css/custom.css') }}
        {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') }}
    </head>
    <body >
        <div class="row">
          <div class="container" style="padding: 5em;">
            <div class="col-xs-12">
              <div class="col-xs-12">
                <div class="col-xs-6">
                  <img src="{{ asset('images/logo-01.png') }}">
                </div>
                <div class="col-xs-6 contdeColor" style="text-align:center;">
                  <h1>Factura Electronica <br>N° {{ $factura->id }}</h1>
                </div>
                <div class="col-xs-12" style="text-align:right;">
                  <h2>{{ date('d-m-Y',strtotime($factura->updated_at)) }}</h2>
                </div>
              </div>
              <div class="col-xs-12 formulario">
                <div class="col-xs-6">
                  <ul class="textoPromedio" style="padding:0;">
                    <li>Cliente:{{ $user->nombre.' '.$user->apellido }}</li>
                    <li>Direccion: {{ $user->dir }}</li>
                    <li>CI/RIF: {{ $user->cedula }}</li>
                  </ul>
                </div>
                <div class="col-xs-6">
                  <ul class="textoPromedio">
                    <li>Telefono: {{ $user->telefono }}</li>
                  </ul>
                </div>
              </div>
              <div class="col-xs-12 formulario">
                <div class="col-xs-12 contdeColor textoPromedio">
                  <div class="col-xs-3" style="text-align:center;">
                    Codigo del articulo
                  </div>
                  <div class="col-xs-3" style="text-align:center;">
                    Cantidad de articulos
                  </div>
                  <div class="col-xs-3" style="text-align:center;">
                    Descripción
                  </div>
                  <div class="col-xs-3" style="text-align:center;">
                    Subtotal
                  </div>
                </div>
              </div>
              <div class="col-xs-12 formulario">
                <div class="col-xs-12 contdeColor">
                  <? $total = 0; ?>
                  @foreach($fact as $f)
                    <div class="col-xs-3 textoPromedio" style="text-align:center;">{{ $f->item_cod }}</div>
                    <div class="col-xs-3 textoPromedio" style="text-align:center;">{{ $f->qty }}</div>
                    <div class="col-xs-3 textoPromedio" style="text-align:center;">{{ $f->item_nomb }}</div>
                    <div class="col-xs-3 textoPromedio" style="text-align:center;">{{ $f->qty*$f->item_precio }}</div>
                    <? $total += $f->qty*$f->item_precio; ?>
                  @endforeach
                </div>
              </div>
              <div class="col-xs-3" style="float:right;text-align:right;">
                <h3 style="display:inline;">Total:</h3>
                <h3 class="precio" style="display:inline;">{{ $total }}</h3>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="col-xs-12">
                <h1>Gracias por su compra</h1>
              </div>
            </div>
          </div>
          <div class="textoPromedio" style="width:100%;height:50px;background:black;text-align:center;color:white;padding-top:1em;"><p>Guacamaya Stores 2015, C.A. RIF: J-40566930-6</p></div>
        </div>          
          
        {{ HTML::script("http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js") }}
        <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script("js/plugins.js") }}
        {{ HTML::script("js/main.js") }}
        {{ HTML::script('js/custom.js') }}
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-57229555-1', 'auto');
          ga('send', 'pageview');

        </script>
        <script type="text/javascript">
          window.print()
        </script>
    </body>
</html>