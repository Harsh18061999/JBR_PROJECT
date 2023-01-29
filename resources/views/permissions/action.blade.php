<div class="d-flex">
    @if($query->lincense != '')
    <a class="pointery license_view" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->name}}"><i class="mx-2 fa-solid fa-eye"></i></a>
    <a type="button" title="Download License" class="mx-2" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->name}}"> <i class="fa-solid fa-download"></i></a>
    @endif
    <a href="{{route('permissions.edit',$query->id)}}" title="Edit Permission" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('permissions_destroy.destroy',$query->id)}}" title="Delete Permission" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
</div>
