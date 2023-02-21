

<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">

        @if($query->lincense != '')
        <a class="dropdown-item pointer license_view" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->first_name.'_'.$query->last_name}}"><i class="fa-solid fa-eye"></i></a>
        <a type="button" title="Download License" class="dropdown-item" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->first_name.'_'.$query->last_name}}"> <i class="fa-solid fa-download"></i></a>
        @endif
        <a href="{{route('user.edit',$query->id)}}" title="Edit User" class="dropdown-item pointer"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
        <a data-href="{{route('user.destory',$query->id)}}" title="Delete User" data-id="{{$query->id}}" class="delete pointer text-danger dropdown-item"><i class=" fa-solid fa-trash"></i> Delete</a>
    </div>
</div>