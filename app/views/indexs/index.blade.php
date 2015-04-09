@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-xs-12 contSlider" style="padding-left:0px;padding-right:0px;">
    	<div class="mySlide">
        @foreach($slides as $s)
    		<div><img src="{{URL::to('images/slides-top/'.$s->image)}}"></div>
        @endforeach
    	</div>
    </div>
</div>  
<div class="row" style="margin-top:2em;">
    <div class="col-xs-12">
      <div class="col-xs-2">
        <div class="col-xs-12 contdeColor">
          <legend>Categorías</legend>
          @foreach($cat as $c)
            <label class="textoPromedio"><i class="fa fa-plus-circle iconToggle" data-toggle="collapse" href="#expand{{ $c->id }}"></i> 
              <a href="{{ URL::to('categorias/'.$c->id) }}" class="aSinFormato">{{ $c->cat_nomb }}</a></label>
            <ul class="collapse textoPromedio" id="expand{{ $c->id }}">
              @foreach($subcat[$c->id] as $j => $s)
                @if(isset($subcat[$c->id][$j]))
                  <li>
                    <a href="{{ URL::to('categorias/'.str_replace(' ','-',$subcat[$c->id][$j]['sub_nomb']).'/'.$subcat[$c->id][$j]['id']) }}" class="aSinFormato">
                      {{ $subcat[$c->id][$j]['sub_nomb'] }}</a></li>
                @endif  
              @endforeach
              
            </ul>
          @endforeach
        </div>
     
      </div>
      <div class="col-xs-8" style="padding-right: 0px;">
        @if(count($art)>0)
        @foreach($art as $a)
          <a href="{{ URL::to('articulo/'.$a->id) }}">
            <div class="col-xs-2 contArtPrinc">
              <img src="{{ asset('images/items/'.$img[$a->id]->image) }}" class="imgArtPrinc imgPrinc">
              <ul class="textoPromedio ulNoStyle">
                <li>
                  <label class="aSinFormato">{{ $a->item_nomb.' - Cod: '.$a->item_cod }}</label>
                </li>
                <li>
                  <p class="precio" style="color:red;">Bs.{{ $a->item_precio }}</p>
                </li>
              </ul>
            </div>
          </a>
        @endforeach
        @else
          <div class="alert alert-warning">
              <p class="textoPromedio" style="text-align:center;">No se encontraron articulos</p>
          </div>
        @endif
      </div>
      <div class="col-xs-2">
        <div class="col-xs-12"><a href="{{ URL::to('images/pub/'.$first->item_id) }}"><img src="{{ asset('images/pub/'.$first->image) }}"></a></div>
        <div class="col-xs-12"><a href="{{ URL::to('images/pub/'.$second->item_id) }}"><img src="{{ asset('images/pub/'.$second->image) }}"></a></div>
      </div>
    </div>
</div>
<div class="col-xs-12 contCentrado bannerBottom" style="margin-top:2em;">
  <div class="col-xs-12" style="margin-bottom:1em;">
    <a href="{{ URL::to('articulo/'.$top->item_id) }}"><img src="{{ asset('images/pub/'.$top->image) }}" style="width:100%;"></a>
  </div>
  <div class="col-xs-6"><a href="{{ URL::to('articulo/'.$left->item_id) }}"><img src="{{ asset('images/pub/'.$left->image) }}" style="width:100%;"></a></div>
  <div class="col-xs-6"><a href="{{ URL::to('articulo/'.$right->item_id) }}"><img src="{{ asset('images/pub/'.$right->image) }}" style="width:100%;"></a></div>
</div>
<div class="clearfix"></div>
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