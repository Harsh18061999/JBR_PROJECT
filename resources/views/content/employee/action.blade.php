

<div class="d-flex">
    @if($query->jobCategory->license_status == 1)
    <a class="dropdown-item pointer license_view" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->first_name.'_'.$query->last_name}}"><i class="mx-2 fa-solid fa-eye"></i> Show</a>
    <a type="button" title="Download License" class="dropdown-item" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->first_name.'_'.$query->last_name}}"> <i class="fa-solid fa-download"></i> Download</a>
    @endif
    <a href="{{route('employee.edit',$query->id)}}" title="Edite Employee" class="dropdown-item pointer"><i class="fa-solid fa-pen-to-square"></i></a>
</div>

