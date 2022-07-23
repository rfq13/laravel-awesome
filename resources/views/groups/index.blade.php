@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Groups</h2>
            </div>
            <div class="pull-right">
                @can('group-create')
                <a class="btn btn-success" href="{{ route('groups.create') }}"> Tambah Group Baru</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>GroupId</th>
            <th>Nama</th>
            <th>Kota</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($groups as $group)
	    <tr>
	        <td>#{{ $group->id }}</td>
	        <td>{{ $group->name }}</td>
	        <td>{{ $group->city }}</td>
	        <td>
                <form action="{{ route('groups.destroy',$group->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('groups.show',$group->id) }}">Show</a>
                    @can('group-edit')
                    <a class="btn btn-primary" href="{{ route('groups.edit',$group->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('group-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $groups->links() !!}


<p class="text-center text-primary"><small> </small></p>
@endsection