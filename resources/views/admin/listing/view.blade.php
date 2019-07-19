@extends('admin.layouts.dashboard')

@section('content')
			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">View Listing </span></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Admin</a>
							<a href="#" class="breadcrumb-item">Listing</a>
							<span class="breadcrumb-item active">View</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">

				<!-- Horizontal form options -->
				<div class="row">
					<div class="col-md-12">

						<!-- Basic layout-->
						<div class="card">
							<div class="card-header header-elements-inline">
								<h5 class="card-title">View Listing</h5>
							</div>
							<div class="card-body">
								
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Title:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="title" value="{{$listing->title}}">
											
										</div>
									</div>
										
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">City:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="city" value="{{$listing->city}}">		
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Address:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="address" value="{{$listing->address}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Size of Property:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="size_of_property" value="{{$listing->size_of_property}} m2">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Currently Lives Here:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="currently_lives_here" value="{{ucfirst($listing->currently_lives_here)}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Max Flatmates Lives Here:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="currently_no_of_persons_lives" value="{{ucfirst($listing->currently_no_of_persons_lives)}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Amenities:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="size_of_property" value="{{$listing->amenities}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">House Rules:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="house_rules" value="{{$listing->rules}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Bed Type:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="bed_type" value="{{$listing->bed_type}}">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Size Of Room:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="size_of_room" value="{{$listing->size_of_room}} m2">	
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Room Availability:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="room_availability" value="{{date('d-m-Y', strtotime($listing->room_availability))}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Monthly Rent:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="monthly_rent" value="{{$listing->monthly_rent}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Bills Included:</label>
										<div class="col-lg-9">
											<input type="checkbox" name="bills_included" 
											@if($listing->bills_included == '1')
												checked="checked"
											@endif >
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Deposit:</label>
										<div class="col-lg-9">
											<input type="checkbox" name="deposit" 
											@if($listing->deposit == '1')
												checked="checked"
											@endif >
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Tell Us More:</label>
										<div class="col-lg-9">
											<input type="text" class="form-control" name="tell_us_more" value="{{$listing->tell_us_more}}">
											
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Images:</label>
										<div class="col-lg-9">
										@foreach($listing->listing_images as $listing_image) 
                                            <a href="#" class="pop">
											   <img src="{{ $listing_image }}" class="img-thumbnail" width="100" />
											</a>
										@endforeach
										    
										</div>
									</div>
									<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
										<div class="modal-content">              
										  <div class="modal-body">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<img src="" class="imagepreview" style="width: 100%;" >
										  </div>
										</div>
									  </div>
									</div>
									<div class="form-group row">
									<label class="col-lg-3 col-form-label">Description</label>
										<!-- CKEditor default -->
									<div class="mb-3">
										<textarea name="description" id="editor-full" rows="4" cols="4">{{$listing->description}}
										</textarea>
									</div>
				                       <!-- /CKEditor default -->
									</div>
									
									
							</div>
						</div>
						<!-- /basic layout -->

					</div>
				</div>
			</div>
			<!-- /content area -->
<script type="text/javascript">
$(function() {
		$('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});		
});
</script>	
@endsection
 