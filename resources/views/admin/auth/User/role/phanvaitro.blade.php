@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Cấp quyền cho user</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <p>
        {{
            $user->name
        }}
    </p>
    <form action="{{ route('storeRole', ['id' => $user->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="role">Vai Trò</label>
            @foreach ($roles as $key => $role)
                <div class="form-check form-check-inline">
                    <input type="radio" name="role" id="{{ $role->id }}"  value="{{$role->name}}"
                        @if($all_colum_roles && $role->id == $all_colum_roles->id) checked @endif>
                    <label for="{{ $role->id }}">
                        {{ $role->name }}
                    </label>

                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Cập Nhật Quyền</button>
    </form>
    <form action="{{route('storeRoles')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" name="role" id="role" class="form-control" required value="{{old('role')}}">
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Add Role</button>
    </form>
</div>
@endsection
