@php
    if($query->status == 0){
        $color = "bg-primary";
    }else if($query->status == 1){
        $color = "bg-success";
    }else if($query->status == 2){
        $color = "bg-warning";
    }else if($query->status == 3){
        $color = "bg-danger";
    }else{
        $color = "";
    }
@endphp
<!-- <select name="status" class="{{$color}} user_status" data-status="{{$query->status}}" data-href="{{route('user.status_update',$query->id)}}">
    <option value="1" class="bg-success" {{$query->status == 1 ? 'selected' : ''}}>ACTIVE1</option>
    <option value="0" class="bg-danger" {{$query->status == 0 ? 'selected' : ''}}>INACTIVE</option>
</select> -->

<label class="switch">
    <input data-href="{{route('user.status_update',$query->id)}}" name="status" data-status="{{$query->status}}" class="user_status" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $query->status ? 'checked' : '' }}>
  <span class="slider round"></span>
</label>
