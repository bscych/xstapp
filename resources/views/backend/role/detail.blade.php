@extends('layouts.app_backend')

@section('content')

    <div class="row">
         @foreach($permissions as $permission)
        <div class="col col-md-3">
            
            
             <label class="checkbox-inline">
                 <input type="checkbox"  onChange="updateRolePermission({{$role_id}},{{$permission->id}}, '{{ route('updateRolePermission') }}')"  id="{{$permission->id}}" {{$role->hasPermissionTo($permission)?'checked="checked"':''}} >
                 {{$permission->name}}
             </label>
        
        </div>
         @endforeach
      
    </div>

   
    <script>

    </script>
    <!--/span-->

</div><!--/row-->

@endsection
