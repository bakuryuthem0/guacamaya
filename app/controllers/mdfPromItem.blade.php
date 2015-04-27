@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($items as $i)
					<tr>
						<td>{{ $item->item_cod }}</td>
						<td>{{ asset('images/item/'.$item->image) }}</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop