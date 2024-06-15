@if ($errors->any())
<div>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<form action="{{ url('users/update', $user->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<label for="name" class="control-label">Name</label>
	<input type="text" name="name" class="form-control" value="{{ $user->name }}">
	<label for="email" class="control-label">Email</label>
	<input type="email" name="email" class="form-control" value="{{ $user->email }}">
	<label for="password" class="control-label">Password</label>
	<input type="password" name="password" class="form-control">
	<label for="password_confirmation" class="control-label">Confirm Password</label>
	<input type="password" name="password_confirmation" class="form-control">
	<label for="address" class="control-label">Address</label>
	<input type="text" name="address" class="form-control" value="{{ $user->address }}">
	<label for="phone" class="control-label">Phone</label>
	<input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
	<label for="photo" class="control-label">Photo</label>
    <input type="file" name="photo" class="form-control">
	<label for="social_media_id" class="control-label">Social Media ID</label>
	<input type="number" name="social_media_id" class="form-control" value="{{ $user->social_media_id }}">
	<label for="role_id" class="control-label">Role ID</label>
	<input type="number" name="role_id" class="form-control" value="{{ $user->role_id }}">
	<button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
</form>
