<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">

        <a href="{{ route('client.edit', $query->id) }}" title="Edite Client" class="dropdown-item pointer"><i
                class="fa-solid fa-pen-to-square"></i> Edit</a>
        {{-- <a data-href="{{ route('client.destory', $query->id) }}" title="Delete client" data-id="{{ $query->id }}"
            class="delete pointer text-danger dropdown-item"><i class="fa-solid fa-trash"></i> Delete</a> --}}
    </div>
</div>
