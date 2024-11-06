<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
    </div>
    <div class="form-group">
        <label>Photo</label>
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="100">
        @endif
        <input type="file" name="photo" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
