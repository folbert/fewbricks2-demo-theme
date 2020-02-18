<{{ $list_tag_name }} type="{{ $list_type }}">

@foreach($items AS $item)

  @if(!is_array($item))
    <li>{{ $item }}</li>
  @else
    <li>@include($template_file_path, $item)</li>
  @endif

@endforeach

</{{ $list_tag_name }}>
