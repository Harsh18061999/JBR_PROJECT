<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></button>
    <div class="dropdown-menu" style="">
        <a class="pointery license_view  dropdown-item" title="View License"
            data-href="{{ asset('storage/assets/' . $query->personal_identification) }}"
            data-pdfname="{{ $query->employee_title->first_name . '_' . $query->employee_title->last_name }}"><i
                class=" fa-solid fa-eye"></i> Show</a>
        <a type="button" title="Download License" class=" dropdown-item"
            href="{{ asset('storage/assets/' . $query->personal_identification) }}" target="_blank"
            download="{{ $query->employee_title->first_name . '_' . $query->employee_title->last_name }}"> <i
                class="fa-solid fa-download"></i> Download</a>
        <a href="{{ route('data_entry_point.edit', $query->id) }}" title="Edite" class=" dropdown-item pointer"><i
                class="fa-solid fa-pen-to-square"></i> Edit</a>
        <a data-href="{{ route('data_entry_point.destory', $query->id) }}" title="Delete" data-id="{{ $query->id }}"
            class=" dropdown-item delete pointer text-danger"><i class=" fa-solid fa-trash"> </i>Delete</a>
    </div>
</div>
