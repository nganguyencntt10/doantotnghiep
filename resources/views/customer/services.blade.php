@extends('customer.layout')
@section('title', 'Danh sách dịch vụ')
			
@section('body')
			
			
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page">Danh sách dịch vụ</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Danh sách dịch vụ</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
	
	<!-- Page Content -->
	<div class="content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12 col-lg-12 col-xl-12">
				
					<div class="row row-grid">
					<?php foreach ($services as $key => $value): ?>
						<div class="col-md-6 col-lg-4 col-xl-3">
							<div class="card widget-profile pat-widget-profile">
								<div class="card-body">
									<div class="pro-widget-content">
										<div class="profile-info-widget">
											<a href="patient-profile.html" class="booking-doc-img">
												<img src="{{ $value->image }}" alt="User Image">
											</a>
											<div class="profile-det-info">
												<h3><a href="{{ route('customer.service', ['slug' => $value->slug]) }}"><?php echo $value->name ?></a></h3>
												
												<div class="patient-details">
													<h5 class="mb-0"><?php echo $value->description ?></h5>
												</div>
											</div>
										</div>
									</div>
									<div class="patient-info">
										<ul>
											<?php foreach ($value->services_procedure as $key => $value): ?>
												<li><?php echo $value->name ?> <span><?php echo $value->time . ' phút'?></span></li>
											<?php endforeach ?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach ?>
						
					</div>

				</div>
			</div>

		</div>

	</div>		
	<!-- /Page Content -->
   
@endsection()