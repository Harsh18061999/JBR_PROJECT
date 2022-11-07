<div class="d-flex">
    <a href="{{route('client.edit',$query->id)}}" title="Edite Client" class="pointer"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
    <a data-href="{{route('client.destory',$query->id)}}" title="Delete client" data-id="{{$query->id}}" class="delete pointer text-danger"><i class="mx-2 fa-solid fa-trash"></i></a>
    {{-- @if($query->status != 2)
        <a data-href="{{route('client.block',$query->id)}}" class="text-danger block_client" title="Block"><i class="mx-2 fa-solid fa-lock"></i></a>
    @else
        <a data-href="{{route('client.unblock',$query->id)}}" class="unblock_client"><i class="mx-2 fa-solid fa-lock-open" title="UnBlock"></i></a>
    @endif --}}
</div>