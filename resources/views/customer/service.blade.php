@extends('customer.layout')
@section('title', 'Dịch vụ')
			
@section('body')
	
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo $service->name ?></li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title"><?php echo $service->name ?></h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
	
	<!-- Page Content -->
	<div class="content">
		<div class="container">

			<!-- Doctor Widget -->
			<div class="card">
				<div class="card-body">
					<div class="doctor-widget">
						<div class="doc-info-left">
							<div class="doctor-img">
								<img src="{{ asset($service->image) }}" class="img-fluid" alt="User Image">
							</div>
							<div class="doc-info-cont">
								<h4 class="doc-name"><?php echo $service->name ?></h4>
								<p class="doc-speciality"><?php echo $service->description ?></p>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="d-inline-block average-rating">(35)</span>
								</div>
								<div class="clinic-details">
									<ul class="clinic-gallery">
										<?php foreach ($image_list as $key => $value): ?>
											<?php if ($value): ?>
												<li>
													<a href="{{ asset($value) }}" data-fancybox="gallery">
														<img src="{{ asset($value) }}" alt="Feature">
													</a>
												</li>
											<?php endif ?>
										<?php endforeach ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="doc-info-right">
							<div class="clini-infos">
								<ul>
									<li><i class="far fa-comment"></i> 35 Đánh giá</li>
									<li><i class="far fa-money-bill-alt"></i> <?php echo number_format($prices) . ' đ' ?> </li>
								</ul>
							</div>
							<div class="clinic-booking">
								<a class="apt-btn" href="booking.html">Book Appointment</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Doctor Widget -->
			
			<!-- Doctor Details Tab -->
			<div class="card">
				<div class="card-body pt-0">
				
					<!-- Tab Menu -->
					<nav class="user-tabs mb-4">
						<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
							<li class="nav-item">
								<a class="nav-link active" href="#doc_overview" data-toggle="tab">Tổng quan</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#doc_reviews" data-toggle="tab">Đánh giá</a>
							</li>
						</ul>
					</nav>
					<!-- /Tab Menu -->
					
					<!-- Tab Content -->
					<div class="tab-content pt-0">
					
						<!-- Overview Content -->
						<div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
							<div class="row">
								<div class="col-md-12 col-lg-9">
								
									<!-- About Details -->
									<div class="widget about-widget">
										<h4 class="widget-title">Mô tả</h4>
										<p><?php echo $service->detail ?></p>
									</div>
									<!-- /About Details -->
								
									<!-- Education Details -->
									<div class="widget education-widget">
										<h4 class="widget-title">Quy trình</h4>
										<div class="experience-box">
											<ul class="experience-list">
												<?php foreach ($service->services_procedure as $key => $value): ?>
													<li>
														<div class="experience-user">
															<div class="before-circle"></div>
														</div>
														<div class="experience-content">
															<div class="timeline-content">
																<a href="#/" class="name"><?php echo $value->name ?></a>
																<span class="time">Thời gian ước tính : <?php echo $value->time . ' phút'?></span>
																<div>Phí dịch vụ : <?php echo number_format($value->prices) . ' đ' ?></div>
															</div>
														</div>
													</li>
												<?php endforeach ?>
											</ul>
										</div>
									</div>
									<!-- /Education Details -->
							

								</div>
							</div>
						</div>
						<!-- /Overview Content -->
						
						<!-- Reviews Content -->
						<div role="tabpanel" id="doc_reviews" class="tab-pane fade">
						
							<!-- Review Listing -->
							<div class="widget review-listing">
								<ul class="comments-list">

								
									<!-- Comment List -->
									<li>
										<div class="comment">
											<img class="avatar avatar-sm rounded-circle" alt="User Image" src="assets/img/patients/patient.jpg">
											<div class="comment-body">
												<div class="meta-data">
													<span class="comment-author">Richard Wilson</span>
													<span class="comment-date">Reviewed 2 Days ago</span>
													<div class="review-count rating">
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star"></i>
													</div>
												</div>
												<p class="comment-content">
													Lorem ipsum dolor sit amet, consectetur adipisicing elit,
													sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
													Ut enim ad minim veniam, quis nostrud exercitation.
													Curabitur non nulla sit amet nisl tempus
												</p>
											</div>
										</div>
									</li>
									<!-- /Comment List -->
									
								</ul>
								
								<!-- Show All -->
								<div class="all-feedback text-center">
									<a href="#" class="btn btn-primary btn-sm">
										Hiển thị tất cả đánh giá <strong>(167)</strong>
									</a>
								</div>
								<!-- /Show All -->
								
							</div>
							<!-- /Review Listing -->
						
							<!-- Write Review -->
							<div class="write-review">
								<h4>Viết đánh giá cho dịch vụ <strong><?php echo $service->name ?></strong></h4>
								
								<!-- Write Review Form -->
								<form>
									<div class="form-group">
										<label>Đánh giá</label>
										<div class="star-rating">
											<input id="star-5" type="radio" name="rating" value="star-5">
											<label for="star-5" title="5 stars">
												<i class="active fa fa-star"></i>
											</label>
											<input id="star-4" type="radio" name="rating" value="star-4">
											<label for="star-4" title="4 stars">
												<i class="active fa fa-star"></i>
											</label>
											<input id="star-3" type="radio" name="rating" value="star-3">
											<label for="star-3" title="3 stars">
												<i class="active fa fa-star"></i>
											</label>
											<input id="star-2" type="radio" name="rating" value="star-2">
											<label for="star-2" title="2 stars">
												<i class="active fa fa-star"></i>
											</label>
											<input id="star-1" type="radio" name="rating" value="star-1">
											<label for="star-1" title="1 star">
												<i class="active fa fa-star"></i>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label>Tiêu đề</label>
										<input class="form-control" type="text" placeholder="If you could say it in one sentence, what would you say?">
									</div>
									<div class="form-group">
										<label>Đánh giá của banj</label>
										<textarea id="review_desc" maxlength="100" class="form-control"></textarea>
									  
									  	<div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">100</span> characters remaining</small></div>
									</div>
									<hr>
									<div class="submit-section">
										<button type="submit" class="btn btn-primary submit-btn">Add Review</button>
									</div>
								</form>
								<!-- /Write Review Form -->
								
							</div>
							<!-- /Write Review -->
				
						</div>
						<!-- /Reviews Content -->
						
					</div>
				</div>
			</div>
			<!-- /Doctor Details Tab -->

		</div>
	</div>		
	<!-- /Page Content -->
   
@endsection()