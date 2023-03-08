<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">
        <a href="{{ route('job_request.edit', $query->id) }}" title="Edite Job Request" class="pointer dropdown-item"><i
                class="fa-solid fa-pen-to-square"></i> Edit</a>
        {{-- <a data-href="{{ route('job_request.destory', $query->id) }}" title="Delete Job Request"
            data-id="{{ $query->id }}" class="delete pointer text-danger dropdown-item "><i
                class=" fa-solid fa-trash"></i> Delete</a> --}}
    </div>
</div>
