@extends('layouts.admin')

@section('content')

<div>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
        <div class="container mx-auto px-6 py-2">
            <div class="text-right">
                <!-- @can('Permission create')
                <a href="{{ route('admin.permissions.create') }}" class="bg-blue-500 text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors">New Permission</a>
                @endcan -->
            </div>

            <div class="bg-white shadow-md rounded my-6 permission px-4 py-2">
                <table class="text-left w-full border-collapse w-100">
                    <thead>
                        <tr class="d-flex">
                            <th class="py-2 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Permission Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @can('Permission access')
                        @foreach($permissions as $permission)
                        <tr class="hover:bg-grey-lighter d-inline-flex">
                            <td class="  items-center justify-center text-grey-dark px-2 py-1 mr-2 mb-2 text-xs font-bold leading-none  bg-gray rounded">{{ $permission->name }}</td>
                            <!-- <td class="py-2 px-6 border-b border-grey-light text-right">
                                 @can('Permission edit')
                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                                @endcan -->

                                <!-- @can('Permission delete')
                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
                                </form>
                                @endcan -->
                            <!-- </td> --> 
                        </tr>
                        @endforeach
                        @endcan
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-delete', function () {
            // ... SweetAlert2 delete confirmation logic ...
        })
    })
</script>
@endsection
