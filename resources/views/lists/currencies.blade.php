<option value="">--اختر الدولة --</option>
@foreach($currencies as $currency)
 
    <option value="{{$currency->id}}">{{$currency->name}}</option>
@endforeach