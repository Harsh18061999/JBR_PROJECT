{{-- <div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">
       
    </div>
</div> --}}
<div class="d-flex justify-content-center">
        @if($query->status < 1)
            <a href="{{ route('job_request.edit', $query->id) }}" title="Edite Job Request" class="pointer me-2"><i
            class="fa-solid fa-pen-to-square"></i></a>
        @else
                -
        @endif
        @if($query->status == 0)
        <a data-href="{{ route('job_request.destory', $query->id) }}" title="Delete Job Request"
            data-id="{{ $query->id }}" class="delete pointer text-danger "><i
                class=" fa-solid fa-trash"></i></a>
        @endif
</div>
