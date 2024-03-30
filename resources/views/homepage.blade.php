@extends('layouts.default')

@section('page_name', 'Users Data')
@section('content')
    <!-- CODE HERE -->
    <div class="float-right pb-4">
        <a href="{{ url('/add-user') }}" class="btn btn-success"> Add User </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td width="35px">#</td>
                <td>Title</td>
                <td>Name</td>
                <td>Email</td>
                <td>Avatar</td>
                <td width="180px">Tools</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->title?->tit_name ?? 'N/A' }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    @if ($user->avatar)
                        <img src="{{asset('storage/avatars/' . $user->avatar)}}"  width="80">
                    @else
                        <span>ไม่มีรูป</span>
                    @endif
                    </td>
                    <td>
                        <a href="{{ route('edit.user', $user->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('delete.user', ['id' => $user->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="c_delete({{ $user->id }})">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function c_delete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/delete-user/' + userId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            }
                        });
                        location.reload(); 
                    }   
                }
            });
        }
    </script>
@endsection