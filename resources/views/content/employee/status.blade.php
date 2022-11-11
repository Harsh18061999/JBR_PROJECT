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
<select name="job" class="{{$color}} employee_status" data-status="{{$query->status}}" data-href="{{route('employee.status_update',$query->id)}}">
    <option value="0" class="bg-primary" {{$query->status == 0 ? 'selected' : ''}}>Regular</option>
    <option value="1" class="bg-success" {{$query->status == 1 ? 'selected' : ''}}>Available</option>
    <option value="2" class="bg-warning" {{$query->status == 2 ? 'selected' : ''}}>Not Available</option>
    <option value="3" class="bg-danger" {{$query->status == 3 ? 'selected' : ''}}>Block</option>
</select>
