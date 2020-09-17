@if(strlen($text) > $limit)
<span class="tooltipped" data-position="bottom" data-tooltip="{{ $text }}">{{ \Illuminate\Support\Str::limit($text, 50) }}</span>
@else
{{ $text }}
@endif