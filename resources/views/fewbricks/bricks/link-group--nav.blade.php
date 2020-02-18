<div class="{{ $main_wrapper_css_classes }}">

  <ul>
  @foreach($links AS $link)
    <li>{!! $link->render() !!}</li>
  @endforeach
  </ul>

</div>
