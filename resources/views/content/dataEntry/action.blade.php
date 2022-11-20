<div class="d-flex">
    <a class="pointery license_view" title="View License" data-href="{{asset('storage/assets/'.$query->personal_identification)}}" data-pdfname="{{$query->employee_title->first_name.'_'.$query->employee_title->last_name}}"><i class="mx-2 fa-solid fa-eye"></i></a>
    <a type="button" title="Download License" class="mx-2" href="{{asset('storage/assets/'.$query->personal_identification)}}" target="_blank" download="{{$query->employee_title->first_name.'_'.$query->employee_title->last_name}}"> <i class="fa-solid fa-download"></i></a>
    <a href="{{route('data_entry_point.edit',$query->id)}}" title="Edite" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('data_entry_point.destory',$query->id)}}" title="Delete" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
</div>