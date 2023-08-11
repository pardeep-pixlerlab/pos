@extends('layouts.admin')
@section('content')
<div>
  <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container mx-auto px-6 py-2">
      <div class="text-right">
      @can('Role create') 
        <a href="{{ route('admin.roles.create') }}" class="bg-blue text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors">New Role</a>
        @endcan
      </div>
      <div class="bg-white shadow-md rounded my-6 text-grey-dark px-4 py-2">
        <table class="text-left w-full border-collapse permission_roles">
          <!-- Table headers and other markup... -->

          <tbody>
            @foreach ($roles as $role)
            <tr class="hover:bg-grey-lighter">
              <td class="py-2 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light w-2/12"><strong class="font-bold">{{ $role->name }}</strong></td>
              <td class="py-2 px-6 border-b border-grey-light">
                @foreach ($role->permissions as $permission)
                <span class="d-inline-flex items-center justify-center text-grey-dark px-2 py-1 mr-2 mb-2 text-xs font-bold leading-none bg-gray rounded">{{ $permission->name }}</span>
                @endforeach
              </td>
              <td class="py-2 px-6 border-b border-grey-light text-right">
                <div class="d-flex align-item-center justify-content-end">
                @can('Role edit')
                  <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                  @endcan
                  
                  @can('Role delete')
                  <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline">
                    @csrf
                    @method('delete')
                    <button class="text-grey-lighter font-bold ml-2 border border-primary py-1 px-3 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
                  </form>
                  @endcan
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
@endsection
