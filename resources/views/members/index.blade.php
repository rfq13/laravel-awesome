@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Member</h2>
            </div>
            <div class="pull-right">
                @can('member-create')
                <a class="btn btn-success" href="{{ route('members.create') }}"> Tambah Member Baru</a>
                <a class="btn btn-info text-light" href="#" data-toggle="modal" data-target="#importModal"> Import Data Member</a>
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
            <th>MemberId</th>
            <th>Nama</th>
            <th>Group</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($members as $member)
	    <tr>
	        <td>#{{ $member->id }}</td>
	        <td>{{ $member->name }}</td>
	        <td>{{ $member->group->name }}</td>
	        <td>
                <form action="{{ route('members.destroy',$member->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('members.show',$member->id) }}">Show</a>
                    @can('member-edit')
                    <a class="btn btn-primary" href="{{ route('members.edit',$member->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('member-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    


    {!! $members->links() !!}


<p class="text-center text-primary"><small> </small></p>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('members.import')}}" id="import-form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="event.preventDefault();
          document.getElementById('import-form').reset();" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="event.preventDefault();
          document.getElementById('import-form').submit();">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection