<div class="d-flex">
    <a href="{{route('job_request.edit',$query->id)}}" title="Edite Job Request" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('job_request.destory',$query->id)}}" title="Delete Job Request" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
</div>