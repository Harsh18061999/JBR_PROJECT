<div class="d-flex">
    <a href="{{route('client.edit',$query->id)}}" title="Edite Client" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('client.destory',$query->id)}}" title="Delete client" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
</div>