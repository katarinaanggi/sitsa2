<div style="white-space: nowrap;">
  <a 
    class="button edit" 
    onclick="event.preventDefault();edit({{$model->id}})" 
    data-bs-toggle="tooltip" 
    title="edit category" >
    <i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
    
  <a 
    class="button delete-confirm" 
    onclick="event.preventDefault();destroy({{$model->id}}, '{{$model->gambar}}')" 
    data-bs-toggle="tooltip" title="delete category">
    <i class="bi bi-trash-fill text-danger"></i></a>&nbsp;

</div>
{{-- 
  href="{{ route('admin.reset_category', $model->id) }}" 
  href="{{ route('admin.edit_category', $model->id) }}" 
  href="{{ route('admin.delete_category', $model->id) }}"
--}}
  