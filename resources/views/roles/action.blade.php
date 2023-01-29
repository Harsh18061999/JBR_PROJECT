<div class="d-flex">
    @if($query->lincense != '')
    <a class="pointery license_view" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->first_name.'_'.$query->last_name}}"><i class="mx-2 fa-solid fa-eye"></i></a>
    <a type="button" title="Download License" class="mx-2" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->first_name.'_'.$query->last_name}}"> <i class="fa-solid fa-download"></i></a>
    @endif
    <a href="{{route('roles.edit',$query->id)}}" title="Edit Role" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('roles_destroy.destroy',$query->id)}}" title="Delete Role" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
</div>