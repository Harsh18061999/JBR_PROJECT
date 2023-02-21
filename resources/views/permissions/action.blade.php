
<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">

        <a href="{{ route('permissions.edit', $query->id) }}" title="Edit Permission" class="dropdown-item pointer"><i
                class="fa-solid fa-pen-to-square "></i></a>
        <a data-href="{{ route('permissions_destroy.destroy', $query->id) }}" title="Delete Permission"
            data-id="{{ $query->id }}" class="dropdown-item delete pointer text-danger"><i
                class=" fa-solid fa-trash"></i></a>
    </div>
</div>
