<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <style type="text/css">
         .btn {
           display: inline-block;
           padding: 6px 12px;
           margin-bottom: 0;
           font-size: 14px;
           font-weight: normal;
           line-height: 1.42857143;
           text-align: center;
           white-space: nowrap;
           vertical-align: middle;
           -ms-touch-action: manipulation;
               touch-action: manipulation;
           cursor: pointer;
           -webkit-user-select: none;
              -moz-user-select: none;
               -ms-user-select: none;
                   user-select: none;
           background-image: none;
           border: 1px solid transparent;
           border-radius: 4px;
         }
         .btn-success {
  color: #fff;
  background-color: #5cb85c;
  border-color: #4cae4c;
}
.btn-success:hover,
.btn-success:focus,
.btn-success.focus,
.btn-success:active,
.btn-success.active,
.open > .dropdown-toggle.btn-success {
  color: #fff;
  background-color: #449d44;
  border-color: #398439;
}
.btn-success:active,
.btn-success.active,
.open > .dropdown-toggle.btn-success {
  background-image: none;
}
.btn-success.disabled,
.btn-success[disabled],
fieldset[disabled] .btn-success,
.btn-success.disabled:hover,
.btn-success[disabled]:hover,
fieldset[disabled] .btn-success:hover,
.btn-success.disabled:focus,
.btn-success[disabled]:focus,
fieldset[disabled] .btn-success:focus,
.btn-success.disabled.focus,
.btn-success[disabled].focus,
fieldset[disabled] .btn-success.focus,
.btn-success.disabled:active,
.btn-success[disabled]:active,
fieldset[disabled] .btn-success:active,
.btn-success.disabled.active,
.btn-success[disabled].active,
fieldset[disabled] .btn-success.active {
  background-color: #5cb85c;
  border-color: #4cae4c;
}
.btn-success .badge {
  color: #5cb85c;
  background-color: #fff;
}
.bg-primary {
  color: #fff;
  background-color: #337ab7;
}
.bg-primary:hover {
  background-color: #286090;
}
      </style>
   </head>
   <body style="font-family:'Roboto','san serif';padding:2em 4em;">
      <img src="http://localhost/prueba/guacamaya/public/images/logo2.png" style="width:40%;">
      <div>
      	<legend>Estimado usuario</legend>
         <ul>
            <li>Este mensaje le fue enviado debido a su solicitud de inscripción en <strong>guacamayastores.com.ve</strong>. Para completar el proceso de registro en nuestro portal sólo necesita hacer click en el siguiente botón.</li>
         </ul>
	     
	      <a href="{{ $link }}" class="btn btn-success" style="margin:2em auto;display:block;width: 150px;">Confirma tu cuenta</a>
         <p>Si no puedes ver el botón, copia este enlace en tu navegador</p>
         <p class="bg-primary" style="padding:1em;">{{ $link }}</p>
         <ul>
            <li>Si usted no solicitó el registro en <strong>guacamayastores.com.ve</strong>, por favor ignore o borre este mensaje</li>
            <li>Si tiene alguna duda o necesita mas información. llámenos al teléfono (x)xxx-xxxx, escribanos mediante el chat en el portal, o escríbanos a los correos electrónicos <span class="bg-primary" style="padding:0px 0.5em;">123456789@hotmail.com</span> o <span class="bg-primary" style="padding:0px 0.5em;">xxxxxxxx@hotmail.com</span> sera un placer atenderle</li>
         </ul>
	      <p  style="text-align:center;">Gracias por unirse a nuestra comunidad. Atentamente <span class="bg-primary" style="color:white;">guacamayastores.com.ve</span></p>
	  </div>
   </body>
</html>