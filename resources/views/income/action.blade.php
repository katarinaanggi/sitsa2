<div style="white-space: nowrap;">
  {{-- <a 
    class="button edit" 
    onclick="event.preventDefault();edit({{$model->id}})" 
    data-bs-toggle="tooltip" 
    title="edit income" >
    <i class="bi bi-pencil-square text-warning"></i></a>&nbsp; --}}
    
  <a 
  class="button delete-confirm" 
  onclick="event.preventDefault();destroy({{$model->id}})" 
  data-bs-toggle="tooltip" title="delete income">
  <i class="bi bi-trash-fill text-danger"></i></a>&nbsp;
  
</div>

{{-- href="{{ route('admin.edit_income', $model->id) }}" 
href="{{ route('admin.delete_income', $model->id) }}"
href="{{ route('admin.reset_income', $model->id) }}"  --}}

  