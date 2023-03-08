<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">
      <a data-href="{{route('job_category.edit',$query->id)}}" data-editurl="{{route('job_category.update',$query->id)}}" class="dropdown-item pointer edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
      {{-- <a data-href="{{route('job_category.destroy',$query->id)}}" data-id="{{$query->id}}" class="dropdown-item delete pointer text-danger"><i class="fa-solid fa-trash"></i> Delete</a> --}}
    </div>
  </div>

  {{-- <div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu show" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-40.9091px, 27.2727px, 0px);" data-popper-placement="bottom-end">
      <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
      <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
    </div>
  </div> --}}