<div class="d-flex">
    @if($query->lincense != '')
    <a class="pointery license_view" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->first_name.'_'.$query->last_name}}"><i class="mx-2 fa-solid fa-eye"></i></a>
    <a type="button" title="Download License" class="mx-2" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->first_name.'_'.$query->last_name}}"> <i class="fa-solid fa-download"></i></a>
    @endif
    <a href="{{route('employee.edit',$query->id)}}" title="Edite Employee" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('employee.destory',$query->id)}}" title="Delete Employee" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
    @if($query->status != 2)
        <a data-href="{{route('employee.block',$query->id)}}" class="text-success   block_employee" title="Block"> <i class="mx-2 fa-solid fa-lock-open" title="UnBlock"></i></a>
    @else
        <a data-href="{{route('employee.unblock',$query->id)}}" class="unblock_employee text-danger"><i class="mx-2 fa-solid fa-lock"></i></a>
    @endif
</div>