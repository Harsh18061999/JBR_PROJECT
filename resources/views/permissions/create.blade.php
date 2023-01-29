@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="bg-light p-4 rounded">
    <div class="text-center p-0">
            <h3><strong><i class="fa-solid fa-user mx-2"></i>Add Permission</strong></h3>
        </div>

        <div class="container mt-4">
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Save permission</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection