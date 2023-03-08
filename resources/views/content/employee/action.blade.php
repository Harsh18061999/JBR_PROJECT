<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">
        @if($query->jobCategory->license_status == 1)
        <a class="dropdown-item pointer license_view" title="View License" data-href="{{asset('storage/assets/'.$query->lincense)}}" data-pdfname="{{$query->first_name.'_'.$query->last_name}}"><i class="mx-2 fa-solid fa-eye"></i> Show</a>
        <a type="button" title="Download License" class="dropdown-item" href="{{asset('storage/assets/'.$query->lincense)}}" target="_blank" download="{{$query->first_name.'_'.$query->last_name}}"> <i class="fa-solid fa-download"></i> Download</a>
        @endif
        <a href="{{route('employee.edit',$query->id)}}" title="Edite Employee" class="dropdown-item pointer"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
        {{-- <a data-href="{{route('employee.destory',$query->id)}}" title="Delete Employee" data-id="{{$query->id}}" class="delete pointer text-danger dropdown-item"><i class=" fa-solid fa-trash"></i> Delete</a> --}}
    </div>
</div>

