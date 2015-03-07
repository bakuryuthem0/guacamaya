@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-xs-12 contSlider" style="padding-left:0px;padding-right:0px;">
    	<div class="mySlide">
    		<div><img src="{{URL::to('images/slides-top/slider1-01.png')}}"></div>
    		<div><img src="{{URL::to('images/slides-top/slider2-01.png')}}"></div>
    		<div><img src="{{URL::to('images/slides-top/slider3-01.png')}}"></div>
    	</div>
    </div>
</div>  
<div class="row" style="margin-top:2em;">
  <div class="container">
    <div class="col-xs-12">
      <div class="col-xs-2">
        <div class="col-xs-12 contdeColor">
          <legend>Categorías</legend>
          <label class="textoPromedio">DAMAS</label>
          <ul class="textoPromedio">
            <li>Camisa</li>
            <li>Blusa</li>
            <li>Vestido</li>
            <li>Pantalones</li>
            <li>Ropa deportiva</li>
          </ul>
          <label class="textoPromedio" style="margin-top:2em;">CABALLEROS</label>
          <ul class="textoPromedio">
            <li>Franelas</li>
            <li>Chemises</li>
          </ul>
          <label class="textoPromedio" style="margin-top:2em;">ACCESORIOS</label>
        </div>
      </div>
      <div class="col-xs-10" style="padding-right: 0px;">
        
      </div>
    </div>
  </div>
</div>
<div class="col-xs-6 contCentrado">
  <img src="{{URL::to('images/slides-top/slider1-01.png')}}">
</div>
@stop

@section('postscript')
	 <script type="text/javascript">
          $(document).ready(function(){
            $('.mySlide').slick({
              adaptiveHeight: false,
              accessibility:true,
              autoplay    : true,
              autoplaySpeed : 5000,
              dots: true,
              infinite: true,
              speed: 300,
              slidesToShow: 1,
            });
            $('.fade').slick()
            
            /*$('.fade').slick({
              dots: true,
              infinite: true,
              speed: 500,
              fade: true,
              cssEase: 'linear',
              adaptiveHeight: true,
              autoplay    : true,
              autoplaySpeed : 5000
            });
            */
          });
    </script>
@stop