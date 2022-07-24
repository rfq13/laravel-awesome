@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Member</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('members.index') }}"> kembali</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> terjadi bebera error.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('members.update',$member->id) }}" method="POST" enctype="multipart/form-data">
    	@csrf
        @method('PUT')


        <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nama:</strong>
		            <input value="{{ old('name') ?? $member->name }}" type="text" name="name" class="form-control" placeholder="Nama">
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Group:</strong>
		            <select name="group_id" id="group_id" class="form-control">
                        <option value="">Pilih Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ $group->id==(old('group_id') ?? $member->group_id) ? 'selected':'' }} >{{ $group->name }}</option>
                        @endforeach
                    </select>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Alamat:</strong>
		            <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ old('address') ?? $member->address }}</textarea>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Hp:</strong>
		            <input value="{{ old('phone') ?? $member->phone }}" type="text" class="form-control" name="phone">
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Email:</strong>
		            <input value="{{ old('email') ?? $member->email }}" type="email" class="form-control" name="email">
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Profile Pic:</strong>
		            <input type="file" class="form-control" name="profile_pic" accept="image/*">

                    <img src="{{$member->profile_pic}}" class="img-fluid mt-2" style="max-width: 35%" alt="" srcset="">
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>
    </form>


<p class="text-center text-primary"><small> </small></p>
@endsection