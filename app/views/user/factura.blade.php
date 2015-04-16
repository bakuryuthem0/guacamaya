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
          <div class="container">
            <div class="col-xs-12">
              <h1>Factura digital guacamayastores.com.ve</h1>
              <h3>Datos del Cliente</h3>
              <ul class="textoPromedio">
                <li>Cliente:{{ $user->nombre.' '.$user->apellido }}</li>
                <li>Direccion: {{ $user->dir }}</li>
                <li>CI/RIF: {{ $user->cedula }}</li>
              </ul>
              <h3 style="text-align:center;">FACTURA</h3>
              <br>
              <table class="table table-hover textoPromedio">
                <tr><td>FACTURA</td><td>{{ $factura->id }}</td></tr>
                <tr><td>FECHA</td><td>{{ $factura->updated_at }}</td></tr>
              </table>
              <table class="table table-hover">
                <thead>
                  <tr class="textoPromedio">
                    <th>Codigo del articulo</th>
                    <th>Cantidad de articulos</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <? $total = 0; ?>
                  @foreach($fact as $f)
                  <tr class="textoPromedio">
                    <td>{{ $f->item_cod }}</td>
                    <td>{{ $f->qty }}</td>
                    <td>{{ $f->item_precio }}</td>
                    <td>{{ $f->qty*$f->item_precio }}</td>
                    <? $total += $f->qty*$f->item_precio; ?>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td><h3>Total:</h3></td>
                    <td><h3 class="precio">{{ $total }}</h3></td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
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