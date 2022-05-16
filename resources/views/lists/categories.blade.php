<option value="">--اختر التصنيف--</option>
@foreach($categories as $category)

    <option value="{{$category->id}}">{{$category->name}}</option>
@endforeach