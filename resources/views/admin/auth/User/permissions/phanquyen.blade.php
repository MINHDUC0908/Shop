@extends('admin.layouts.app')
@section('content')
    <div>
        Cấp quyền cho User: {{$user->name}}
    </div>
    <form action="{{route('storePermission', ['id' => $user->id])}}" method="POST">
        @csrf
        <div>
            Vai trò hiện tại: {{$name_role}}
        </div>
        @foreach ($permission as $key => $item)
            <div class="form-check">
                <input type="checkbox" name="permissions[]" value="{{ $item->name }}" id="{{ $item->id }}" class="form-check-input"
                    @foreach ($get_permission_via_role as $get)
                        @if ($get->id === $item->id)
                            @checked(true)
                        @endif
                    @endforeach
                >
                <label for="{{ $item->id }}" class="form-check-label">
                    {{ $item->name }}
                </label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary btn-sm">Cập Nhật Quyền</button>
    </form>
    <form action="{{route('Permission')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="permission">Permission</label>
            <input type="text" name="permission" id="role" class="form-control" required value="{{old('permission')}}">
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Add Permission</button>
    </form>
@endsection