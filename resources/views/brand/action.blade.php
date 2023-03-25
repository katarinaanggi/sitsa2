<div style="white-space: nowrap;">
  <a 
    class="button edit" 
    onclick="event.preventDefault();edit({{$model->id}})" 
    data-bs-toggle="tooltip" 
    title="edit brand" >
    <i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
    
  <a 
    class="button delete-confirm" 
    onclick="event.preventDefault();destroy({{$model->id}}, '{{$model->gambar}}')" 
    data-bs-toggle="tooltip" title="delete brand">
    <i class="bi bi-trash-fill text-danger"></i></a>&nbsp;
    
  <a 
    class="button show" 
    onclick="event.preventDefault();showlist({{$model->id}})" 
    data-bs-toggle="tooltip" title="show brand">
    <i class="bi bi-list-ul text-info"></i></a>&nbsp;
    
</div>
{{-- 
  href="{{ route('admin.reset_brand', $model->id) }}" 
  href="{{ route('admin.edit_brand', $model->id) }}" 
  href="{{ route('admin.delete_brand', $model->id) }}"
--}}
  