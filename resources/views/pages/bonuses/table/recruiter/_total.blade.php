<div class="internal-table">
    @foreach($data as $code => $values)
        <div class="tr">
           <div class="td">
               <a href="{{ route('people.show', $model) }}">{{ \App\Services\Formatter::currency(array_sum($values), $currency[$code]) }}</a>
           </div>
        </div>
    @endforeach
</div>