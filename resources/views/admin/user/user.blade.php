@extends('admin.layouts.dashboard')

@section('content')

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Users</span> - List</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>                    
					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<!--<a class="btn btn-success" href="{{route('user.create')}}">Add User</a>-->
						</div>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Admin</a>
							<a href="#" class="breadcrumb-item">Users</a>
							<span class="breadcrumb-item active">List</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<!-- Basic tables title -->
				<div class="mb-3">
					<h6 class="mb-0 font-weight-semibold">
						Users List
					</h6>
				</div>
				@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
				    @endif
				<!-- basic tables title -->
				<!-- Hover rows -->
				<div class="card">
					<div class="table-responsive">
						<table class="table datatable-basic" id="users_list">
							<thead>
								<tr>
								    <th>ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Status</th>
									<th>Action</th> 
								</tr>
							</thead>
							<tbody>
								 @foreach( $users as $user)
								  <tr>
								       <td>#{{$user->id}}</td>
									   <td>{{$user->first_name}}</td>
									   <td>{{$user->email}}</td>
									   <td>{{ucfirst($user->role)}}</td>
									   <td>@if ($user->status == '1')
										     Active
                                           @else
                                             Inactive
                                           @endif										 
									   </td>
									  <td>
									  
										<a class="btn btn-{{($user->status == 1) ? 'success' : 'primary' }} rounded-round" href="{{ url('admin/user/status', $user->id)}}/{{($user->status == 1) ? 0 : 1 }}"> @if ($user->status == '1')  Inactive @else Active @endif </a>
									  
									  
									   <form action="{{ route('user.destroy', $user->id)}}" method="post">
											  @csrf
											  @method('DELETE')
									   <button class="btn btn-danger rounded-round" type="submit">Delete</button>
									   </form>
									   </td>
								  </tr>
								   @endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- /hover rows -->
			</div>
			<!-- /content area -->
@endsection 
