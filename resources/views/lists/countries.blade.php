<option value="">--اختر الدولة --</option>
@foreach($countries as $country)
 
    <option value="{{$country->id}}">{{$country->name}}</option>
@endforeach