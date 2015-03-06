@extends('layouts.default')

@section('content')
<div class="col-xs-12 contSlider">
	<div class="mySlide">
		<div><img src="{{URL::to('images/slides-top/slider1-01.png')}}"></div>
		<div><img src="{{URL::to('images/slides-top/slider2-01.png')}}"></div>
		<div><img src="{{URL::to('images/slides-top/slider3-01.png')}}"></div>
	</div>
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