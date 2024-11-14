@extends('admin.layouts.app')

@section('content')
    <h1>Liệt kê Users</h1>
    <a href="{{route('user.create')}}">
        <button>Add người dùng</button>
    </a>
    {{-- <a href="{{ route('add-quyen') }}" class="">
        <button>Add Role</button>
    </a>
    <a href="{{ route('add-quyen') }}" class="">
        <button>Add Permissions</button>
    </a> --}}
    @if (session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Vai trò (Role)</th>
                <th>Quyền (Permissions)</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge badge-primary" style="color: black">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($user->permissions as $role)
                            <span class="badge badge-primary" style="color: black">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('phan-vai-tro', ['id' => $user->id]) }}" class="btn btn-success btn-sm">Phân vai trò</a>
                        <a href="{{ route('phan-quyen', ['id' => $user->id]) }}" class="btn btn-success btn-sm">Phân quyền</a>
                        {{-- <a href="{{ route('impersonate', ['id' => $user->id]) }}" class="btn btn-success btn-sm">Chuyển quyền nhanh</a> --}}
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
