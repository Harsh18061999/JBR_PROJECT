

<div class="d-flex">
    @if($query->jobCategory->license_status == 1)
    <a class="pointer license_view" class="mx-2" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->first_name.'_'.$query->last_name}}"><i class="fa-solid fa-eye"></i></a>
    <a type="button" title="Download License" class="mx-2" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->first_name.'_'.$query->last_name}}"> <i class="fa-solid fa-download"></i></a>
    @endif
    <a href="{{route('employee.edit',$query->id)}}" title="Edite Employee" class=" pointer"><i class="fa-solid fa-pen-to-square"></i></a>
</div>

