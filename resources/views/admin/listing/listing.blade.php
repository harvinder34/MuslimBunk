@extends('admin.layouts.dashboard')

@section('content')

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Listings</span></h4>
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
							<a href="#" class="breadcrumb-item">Listings</a>
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
						Listings
					</h6>
					 @if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
				    @endif
				</div>
				<!-- basic tables title -->
				<!-- Hover rows -->
				<div class="card">
					<div class="table-responsive">
						<table class="table datatable-basic" id="users_list">
							<thead>
								<tr>
								    <th>ID</th>
									<th>Title</th>
									<th>User Name</th>
									<th>City</th>
									<th>Address</th>
									<th>Action</th> 
								</tr>
							</thead>
							<tbody>
								 @foreach( $listings as $listing)
								  <tr>
								       <td><a href="{{ url('admin/listing/view', $listing->id)}}">#{{$listing->id}}</a></td>
									   <td>{{$listing->title}}</td>
									   <td>{{ucfirst($listing->first_name)}}</td>
									   <td>{{$listing->city}}</td>
									   <td>{{$listing->address}}</td>
									  <td>
									  <a class="btn btn-{{($listing->status == 1) ? 'success' : 'primary' }} rounded-round" href="{{ url('admin/listing/status', $listing->id)}}/{{($listing->status == 1) ? 0 : 1 }}"> @if ($listing->status == '1')  Inactive @else Active @endif </a>
									   <form action="{{ url('admin/listing/view', $listing->id)}}" method="post">
											  @csrf	
									    <button class="btn btn-primary rounded-round" type="submit">
										   View
										   </button>
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
