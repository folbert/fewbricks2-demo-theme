<div class="{{ $main_wrapper_css_classes }}">

  @foreach($bricks AS $brick)
    <div class="ec-m-flexible-column__module">
      {!! $brick->render() !!}
    </div>
  @endforeach

</div>
