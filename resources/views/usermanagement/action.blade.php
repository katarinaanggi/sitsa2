<div style="white-space: nowrap;">
  <a 
    class="button edit" 
    onclick="event.preventDefault();edit({{$model->id}})" 
    data-bs-toggle="tooltip" 
    title="edit user" >
    <i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
    
  <a 
    class="button delete-confirm" 
    onclick="event.preventDefault();destroy({{$model->id}})" 
    data-bs-toggle="tooltip" title="delete user">
    <i class="bi bi-trash-fill text-danger"></i></a>&nbsp;

  <a 
    class="button reset-confirm" 
    onclick="event.preventDefault();reset({{$model->id}})" 
    data-bs-toggle="tooltip" title="reset password">
    <i class="bi bi-key-fill text-success"></i></a>
</div>
{{-- 
  href="{{ route('admin.reset_user', $model->id) }}" 
  href="{{ route('admin.edit_user', $model->id) }}" 
  href="{{ route('admin.delete_user', $model->id) }}"
--}}
  