<div style="white-space: nowrap;">
  <a 
    class="button edit" 
    onclick="event.preventDefault();edit({{$model->id}})" 
    data-bs-toggle="tooltip" 
    title="edit product" >
    <i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
    
  <a 
    class="button delete-confirm" 
    onclick="event.preventDefault();destroy({{$model->id}}, '{{$model->gambar}}')" 
    data-bs-toggle="tooltip" title="delete product">
    <i class="bi bi-trash-fill text-danger"></i></a>&nbsp;

</div>
{{-- 
  href="{{ route('admin.reset_product', $model->id) }}" 
  href="{{ route('admin.edit_product', $model->id) }}" 
  href="{{ route('admin.delete_product', $model->id) }}"
--}}
  