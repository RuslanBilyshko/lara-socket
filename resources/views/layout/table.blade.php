<? //dd($headers) ?>
<table class="table">
  <thead>
    <tr>
      {{--<th>#</th>--}}
      @foreach($headers as $header)
        <th>{{$header}}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @if($rows)
	    <?php $index = 0; ?>
	    @foreach($rows as $row)
	      <tr class="row-{{++$index}}">
	        {{--<td>{{$index}}</td>--}}
	        @foreach($row as $item)
						@if(is_array($item))
	            <td class="{{$item['class']}}">{!! $item['value'] !!}</td>
			      @else
				      <td>{!! $item !!}</td>
						@endif
	        @endforeach
	      </tr>
	    @endforeach
		@endif
  </tbody>
</table>