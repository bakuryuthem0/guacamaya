@extends('layouts.default')

@section('content')
<div class="row" style="margin-top:2em;">
  <div class="container">
    <div class="col-xs-12">
      <div class="col-xs-2">
        <div class="col-xs-12 contdeColor">
          <legend>Categorías</legend>
          @foreach($cat as $c)
            <label class="textoPromedio"><i class="fa fa-plus-circle iconToggle" data-toggle="collapse" href="#expand{{ $c->id }}"></i> 
              <a href="{{ URL::to('categorias/'.$c->id) }}" style="color:black;">{{ $c->cat_nomb }}</a></label>
            <ul class="collapse textoPromedio" id="expand{{ $c->id }}">
              @foreach($subcat[$c->id] as $j => $s)
                @if(isset($subcat[$c->id][$j]))
                  <li>
                    <a href="{{ URL::to('categorias/'.str_replace(' ','-',$subcat[$c->id][$j]['sub_nomb']).'/'.$subcat[$c->id][$j]['id']) }}" style="color:black;">{{ $subcat[$c->id][$j]['sub_nomb'] }}</a>
                    </li>
                @endif  
              @endforeach
              
            </ul>
          @endforeach
        </div>
     
      </div>
      <div class="col-xs-10 contdeColor" style="padding-right: 0px;">
        @if(count($art)>0)
        @if(!isset($type))
        <div class="alert alert-success">
          <p class="textoPromedio" style="text-align:center;">Resultados encontrados para <strong>{{ $busq }}</strong></p>
        </div>
        @else
          <h2 style="text-align:center;">{{ $busq }}</h2>
        @endif

        @foreach($art as $a)
          <a href="{{ URL::to('articulo/'.$a->id) }}">
            <div class="col-xs-3 contArtPrinc">
              <img src="{{ asset('images/items/'.$a->image) }}" class="imgArtPrinc imgPrinc">
              <ul class="textoPromedio ulNoStyle">
                <li>
                  <label style="color:black;">{{ $a->item_nomb.' - Cod: '.$a->item_cod }}</label>
                </li>
                <li>
                  <p style="color:red;">Bs.{{ $a->item_precio }}</p>
                </li>
              </ul>
            </div>
          </a>
        @endforeach
        @else
          <div class="alert alert-warning">
              <p class="textoPromedio" style="text-align:center;">No se encontraron articulos {{ 'para: <strong>'.$busq.'</strong>' }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@stop