@extends('layouts/contentNavbarLayout')

<style>
    thead {
        background: #152d47;
        color: white;
        margin-top: 10px;
    }

    .dataTables_filter {
        margin-bottom: 30px;
    }

    .dataTables_filter {
        margin-top: 10px;
    }
</style>

@section("content")
<div class="col-xxl-6">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                <li class="nav-item waves-effect waves-light" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#pill-justified-home-1" role="tab" aria-selected="true">
                        Current Request
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-profile-1" role="tab" aria-selected="false" tabindex="-1">
                        Last Week Job list
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-messages-1" role="tab" aria-selected="false" tabindex="-1">
                        Completed
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#pill-justified-settings-1" role="tab" aria-selected="false" tabindex="-1">
                        Report List
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content text-muted">
                <div class="tab-pane active show" id="pill-justified-home-1" role="tabpanel">
                    <div>
                        <div class="table-responsive text-nowrap p-2">
                            {!! $dataTable->table(['class' => 'w-100'], true) !!}
                            {{ $dataTable->scripts() }}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="pill-justified-profile-1" role="tabpanel">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            In some designs, you might adjust your tracking to create a certain artistic effect. It can also help you fix fonts that are poorly spaced to begin with.
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="pill-justified-messages-1" role="tabpanel">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            Each design is a new, unique piece of art birthed into this world, and while you have the opportunity to be creative and make your own style choices.
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            For that very reason, I went on a quest and spoke to many different professional graphic designers and asked them what graphic design tips they live.
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="pill-justified-settings-1" role="tabpanel">
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            For that very reason, I went on a quest and spoke to many different professional graphic designers and asked them what graphic design tips they live.
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            After gathering lots of different opinions and graphic design basics, I came up with a list of 30 graphic design tips that you can start implementing.
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>
@endsection