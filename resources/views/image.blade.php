@if($image)
<img src="{{ Storage::url($image) }}" width="100" height="75" alt="" />
@else
<img src="https://www.feedough.com/wp-content/uploads/2016/09/brand-image.png" alt="" height="75" width="75">
@endif
