<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<?php
$qtyMember = DB::rowCount("SELECT * FROM users WHERE user_role = 1");
$qtyStaff = DB::rowCount("SELECT * FROM users WHERE user_role = 2");
$qtyAdmin = DB::rowCount("SELECT * FROM users WHERE user_role = 3");
$qtyCate = DB::rowCount("SELECT * FROM category");
$qtyProduct = DB::rowCount("SELECT * FROM product");
$qtyReview = DB::rowCount("SELECT * FROM review WHERE review_parent_id is null");
$qtyOrder = DB::rowCount("SELECT * FROM orders");
$revenueOrder = DB::fetch("SELECT SUM(order_detail.product_price*order_detail.product_quantity) as total_price,SUM(order_detail.product_quantity) as qty FROM order_detail, orders WHERE orders.order_status = 3 AND order_detail.order_id = orders.order_id");
$countProduct = DB::fetchAll("SELECT order_detail.product_id, product.product_name, COUNT(order_detail.product_id) as qty FROM order_detail, product WHERE product.product_id = order_detail.product_id GROUP BY order_detail.product_id ORDER BY qty DESC LIMIT 0,5");
$sumProduct = DB::fetchAll("SELECT order_detail.product_id, product.product_name, SUM(order_detail.product_quantity) as qty FROM order_detail, product WHERE product.product_id = order_detail.product_id GROUP BY order_detail.product_id ORDER BY qty DESC LIMIT 0,5");
?>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
		<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Statistic From Date</h3>
                        </div>
                        <!--begin::Form-->
                        <form id="update-setting">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 col-sm-12">Input Group Setup</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="input-group" id="date_range">
                                            <input type="text" class="form-control" readonly="readonly" placeholder="Select date range">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
									<div class="col-xl-6">
										<!--begin::Stats Widget 13-->
										<a href="#" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000"></path>
														</g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block order_qty-stats"></span>
												<div class="font-weight-bold text-inverse-danger font-size-sm">Order Quantity</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 13-->
									</div>
                                    <div class="col-xl-6">
										<!--begin::Stats Widget 14-->
										<a href="#" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                                <rect x="0" y="7" width="16" height="2" rx="1"/>
                                                                <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                                            </g>
                                                        </g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block order_cancel-stats"></span>
												<div class="font-weight-bold text-inverse-primary font-size-sm">Order Cancel</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 14-->
									</div>
                                    <div class="col-xl-6">
										<!--begin::Stats Widget 14-->
										<a href="#" class="card card-custom bg-warning bg-hover-state-warning card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M22,17 L22,21 C22,22.1045695 21.1045695,23 20,23 L4,23 C2.8954305,23 2,22.1045695 2,21 L2,17 L6.27924078,17 L6.82339262,18.6324555 C7.09562072,19.4491398 7.8598984,20 8.72075922,20 L15.381966,20 C16.1395101,20 16.8320364,19.5719952 17.1708204,18.8944272 L18.118034,17 L22,17 Z" fill="#000000"/>
                                                            <path d="M2.5625,15 L5.92654389,9.01947752 C6.2807805,8.38972356 6.94714834,8 7.66969497,8 L16.330305,8 C17.0528517,8 17.7192195,8.38972356 18.0734561,9.01947752 L21.4375,15 L18.118034,15 C17.3604899,15 16.6679636,15.4280048 16.3291796,16.1055728 L15.381966,18 L8.72075922,18 L8.17660738,16.3675445 C7.90437928,15.5508602 7.1401016,15 6.27924078,15 L2.5625,15 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 3.661508) rotate(-90.000000) translate(-11.959697, -3.661508) "/>
                                                        </g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block order_pending-stats"></span>
												<div class="font-weight-bold text-inverse-primary font-size-sm">Order Pending</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 14-->
									</div>
                                    <div class="col-xl-6">
										<!--begin::Stats Widget 14-->
										<a href="#" class="card card-custom bg-info bg-hover-state-info card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M8,13.1668961 L20.4470385,11.9999863 L8,10.8330764 L8,5.77181995 C8,5.70108058 8.01501031,5.63114635 8.04403925,5.56663761 C8.15735832,5.31481744 8.45336217,5.20254012 8.70518234,5.31585919 L22.545552,11.5440255 C22.6569791,11.5941677 22.7461882,11.6833768 22.7963304,11.794804 C22.9096495,12.0466241 22.7973722,12.342628 22.545552,12.455947 L8.70518234,18.6841134 C8.64067359,18.7131423 8.57073936,18.7281526 8.5,18.7281526 C8.22385763,18.7281526 8,18.504295 8,18.2281526 L8,13.1668961 Z" fill="#000000"/>
                                                            <path d="M4,16 L5,16 C5.55228475,16 6,16.4477153 6,17 C6,17.5522847 5.55228475,18 5,18 L4,18 C3.44771525,18 3,17.5522847 3,17 C3,16.4477153 3.44771525,16 4,16 Z M1,11 L5,11 C5.55228475,11 6,11.4477153 6,12 C6,12.5522847 5.55228475,13 5,13 L1,13 C0.44771525,13 6.76353751e-17,12.5522847 0,12 C-6.76353751e-17,11.4477153 0.44771525,11 1,11 Z M4,6 L5,6 C5.55228475,6 6,6.44771525 6,7 C6,7.55228475 5.55228475,8 5,8 L4,8 C3.44771525,8 3,7.55228475 3,7 C3,6.44771525 3.44771525,6 4,6 Z" fill="#000000" opacity="0.3"/>
                                                        </g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block order_ship-stats"></span>
												<div class="font-weight-bold text-inverse-primary font-size-sm">Order Shipping</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 14-->
									</div>
                                    <div class="col-xl-6">
										<!--begin::Stats Widget 14-->
										<a href="#" class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"/>
                                                        </g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block order_success-stats"></span>
												<div class="font-weight-bold text-inverse-primary font-size-sm">Order Success</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 14-->
									</div>
									<div class="col-xl-6">
										<!--begin::Stats Widget 14-->
										<a href="#" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
															<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
														</g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block product_qty-stats"></span>
												<div class="font-weight-bold text-inverse-primary font-size-sm">Product Sold</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 14-->
									</div>
									<div class="col-xl-6">
										<!--begin::Stats Widget 15-->
										<a href="#" class="card card-custom bg-info bg-hover-state-info card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
															<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
															<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
															<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
														</g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block sum_product-stats"></span>
												<div class="font-weight-bold text-inverse-success font-size-sm">Quantity Product Sold</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 15-->
									</div>
                                    <div class="col-xl-6">
										<!--begin::Stats Widget 15-->
										<a href="#" class="card card-custom bg-dark bg-hover-state-dark card-stretch gutter-b">
											<!--begin::Body-->
											<div class="card-body">
												<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
                                                            <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000"/>
                                                        </g>
													</svg>
													<!--end::Svg Icon-->
												</span>
												<span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block revenue-stats"></span>
												<div class="font-weight-bold text-inverse-success font-size-sm">Revenue</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Stats Widget 15-->
									</div>
								</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="font-weight-bolder">Top 5 Product Sold</p>
                                        <div class="table-reponsive">
                                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                            <thead class="datatable-head">
                                                <tr class="datatable-row" style="left: 0px;">
                                                    <th class="datatable-cell" style="flex-grow:1"><span>Product Name</span></th>
                                                    <th class="datatable-cell" style="width: 30%"><span>Quantity</span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="count-product" class="datatable-body">
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="font-weight-bolder">Top 5 Quantity Product Sold</p>
                                        <div class="table-reponsive">
                                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                            <thead class="datatable-head">
                                                <tr class="datatable-row" style="left: 0px;">
                                                    <th class="datatable-cell" style="flex-grow:1"><span>Product Name</span></th>
                                                    <th class="datatable-cell" style="width: 30%"><span>Quantity</span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="sum-products" class="datatable-body">
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
            <!--end row--> 
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Store Statistic</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col-xl-4">
                                <!--begin::List Widget 1-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label font-weight-bolder text-dark">Users Statistic</span>
                                        </h3>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-8">
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-success mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-success">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <polygon fill="#000000" opacity="0.3" points="5 3 19 3 23 8 1 8"/>
                                                                <polygon fill="#000000" points="23 8 12 20 1 8"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Admin Users</a>
                                                <span class="text-muted"><?=$qtyAdmin?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-danger mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-danger">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Attachment2.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M12.3740377,19.9389434 L18.2226499,11.1660251 C18.4524142,10.8213786 18.3592838,10.3557266 18.0146373,10.1259623 C17.8914367,10.0438285 17.7466809,10 17.5986122,10 L13,10 L13,4.47708173 C13,4.06286817 12.6642136,3.72708173 12.25,3.72708173 C11.9992351,3.72708173 11.7650616,3.85240758 11.6259623,4.06105658 L5.7773501,12.8339749 C5.54758575,13.1786214 5.64071616,13.6442734 5.98536267,13.8740377 C6.10856331,13.9561715 6.25331908,14 6.40138782,14 L11,14 L11,19.5229183 C11,19.9371318 11.3357864,20.2729183 11.75,20.2729183 C12.0007649,20.2729183 12.2349384,20.1475924 12.3740377,19.9389434 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Staff Users</a>
                                                <span class="text-muted"><?=$qtyStaff?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-info mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-info">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
                                                                <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"></path>
                                                                <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"></path>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Members</a>
                                                <span class="text-muted"><?=$qtyMember?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::List Widget 1-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::List Widget 1-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label font-weight-bolder text-dark">Products Statistic</span>
                                        </h3>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-8">
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-success mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-success">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <polygon fill="#000000" opacity="0.3" points="12 20.6599888 9.46440699 20.6354368 7.31805655 19.2852462 5.19825383 17.8937466 4.12259707 15.5974894 3.09160702 13.2808335 3.42815736 10.7675551 3.81331204 8.26126488 5.45521712 6.32891335 7.13423264 4.4287182 9.5601992 3.69080156 12 3 14.4398008 3.69080156 16.8657674 4.4287182 18.5447829 6.32891335 20.186688 8.26126488 20.5718426 10.7675551 20.908393 13.2808335 19.8774029 15.5974894 18.8017462 17.8937466 16.6819434 19.2852462 14.535593 20.6354368"/>
                                                                <circle fill="#000000" opacity="0.3" cx="8.5" cy="13.5" r="1.5"/>
                                                                <circle fill="#000000" opacity="0.3" cx="13.5" cy="7.5" r="1.5"/>
                                                                <circle fill="#000000" opacity="0.3" cx="14.5" cy="15.5" r="1.5"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Categories</a>
                                                <span class="text-muted"><?=$qtyCate?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-danger mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-danger">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Attachment2.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M15,15 L15.9974233,16.1399123 C16.3611054,16.555549 16.992868,16.5976665 17.4085046,16.2339844 C17.4419154,16.20475 17.4733423,16.1733231 17.5025767,16.1399123 L18.5,15 L21,15 C20.4185426,17.9072868 17.865843,20 14.9009805,20 L9.09901951,20 C6.13415704,20 3.58145737,17.9072868 3,15 L15,15 Z" fill="#000000"/>
                                                                <path d="M21,9 L3,9 L3,9 C3.58145737,6.09271316 6.13415704,4 9.09901951,4 L14.9009805,4 C17.865843,4 20.4185426,6.09271316 21,9 Z" fill="#000000"/>
                                                                <rect fill="#000000" opacity="0.3" x="2" y="11" width="20" height="2" rx="1"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Products</a>
                                                <span class="text-muted"><?=$qtyProduct?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-info mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-info">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                                <path d="M12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.3476862,4.32173209 11.9473121,4.11839309 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Reviews</a>
                                                <span class="text-muted"><?=$qtyReview?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::List Widget 1-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::List Widget 1-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label font-weight-bolder text-dark">Orders Statistic</span>
                                        </h3>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-8">
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-success mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-success">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M18.1446364,11.84388 L17.4471627,16.0287218 C17.4463569,16.0335568 17.4455155,16.0383857 17.4446387,16.0432083 C17.345843,16.5865846 16.8252597,16.9469884 16.2818833,16.8481927 L4.91303792,14.7811299 C4.53842737,14.7130189 4.23500006,14.4380834 4.13039941,14.0719812 L2.30560137,7.68518803 C2.28007524,7.59584656 2.26712532,7.50338343 2.26712532,7.4104669 C2.26712532,6.85818215 2.71484057,6.4104669 3.26712532,6.4104669 L16.9929851,6.4104669 L17.606173,3.78251876 C17.7307772,3.24850086 18.2068633,2.87071314 18.7552257,2.87071314 L20.8200821,2.87071314 C21.4717328,2.87071314 22,3.39898039 22,4.05063106 C22,4.70228173 21.4717328,5.23054898 20.8200821,5.23054898 L19.6915238,5.23054898 L18.1446364,11.84388 Z" fill="#000000" opacity="0.3"/>
                                                                <path d="M6.5,21 C5.67157288,21 5,20.3284271 5,19.5 C5,18.6715729 5.67157288,18 6.5,18 C7.32842712,18 8,18.6715729 8,19.5 C8,20.3284271 7.32842712,21 6.5,21 Z M15.5,21 C14.6715729,21 14,20.3284271 14,19.5 C14,18.6715729 14.6715729,18 15.5,18 C16.3284271,18 17,18.6715729 17,19.5 C17,20.3284271 16.3284271,21 15.5,21 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Orders</a>
                                                <span class="text-muted"><?=$qtyOrder?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-danger mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-danger">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Attachment2.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                                                                <path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.000019, 10.749981) scale(1, -1) translate(-14.000019, -10.749981) "/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Products Sold</a>
                                                <span class="text-muted"><?=$revenueOrder['qty'] ?? 0?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-40 symbol-light-info mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-info">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1"/>
                                                                <rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1"/>
                                                                <path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Revenue</a>
                                                <span class="text-muted"><?=product_price($revenueOrder['total_price'])?></span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::List Widget 1-->
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="font-weight-bolder">Top 5 Product Sold</p>
                                    <div class="table-reponsive">
                                        <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                        <thead class="datatable-head">
                                            <tr class="datatable-row" style="left: 0px;">
                                                <th class="datatable-cell" style="flex-grow:1"><span>Product Name</span></th>
                                                <th class="datatable-cell" style="width: 30%"><span>Quantity</span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="datatable-body">
                                        <?php foreach($countProduct as $val): ?>
                                            <tr class="datatable-row" style="left: 0px;">
                                                <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?=$val['product_name']?></span></td>
                                                <td class="datatable-cell" style="width: 30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?=$val['qty']?></span></td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="font-weight-bolder">Top 5 Quantity Product Sold</p>
                                    <div class="table-reponsive">
                                        <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                        <thead class="datatable-head">
                                            <tr class="datatable-row" style="left: 0px;">
                                                <th class="datatable-cell" style="flex-grow:1"><span>Product Name</span></th>
                                                <th class="datatable-cell" style="width: 30%"><span>Quantity</span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="datatable-body">
                                        <?php foreach($sumProduct as $val): ?>
                                            <tr class="datatable-row" style="left: 0px;">
                                                <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?=$val['product_name']?></span></td>
                                                <td class="datatable-cell" style="width: 30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?=$val['qty']?></span></td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
	    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        var dateBefore = new Date()
        var today = new Date()
        dateBefore.setMonth(dateBefore.getMonth() - 1)
        $('#date_range input').daterangepicker({
            startDate: dateBefore,
            enđate: today,
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            locale: {
                format: 'DD/MM/YYYY',
            }
        }, function(start, end, label){
            $('#date_range input').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
            getStast($('#date_range input').val())
        })
        function getStast($dateRange){
            $.ajax({
                url         : '../API/product.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'statistic', date_range: $dateRange},
                success     : function(data){
                    console.log(data)
                    $('.order_qty-stats').html(data.order_qty)
                    $('.order_cancel-stats').html(data.order_cancel)
                    $('.order_pending-stats').html(data.order_pending)
                    $('.order_ship-stats').html(data.order_ship)
                    $('.order_success-stats').html(data.order_success)
                    $('.product_qty-stats').html(data.product_qty)
                    $('.sum_product-stats').html(data.sum_product)
                    $('.revenue-stats').html(data.revenue)
                    $countProduct = ''
                    $sumProduct = ''
                    $.each(data.count_product, function(i,v){
                        $countProduct += `<tr class="datatable-row" style="left: 0px;">
                                            <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.product_name +`</span></td>
                                            <td class="datatable-cell" style="width: 30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.qty +`</span></td>
                                        </tr>`
                    })
                    $.each(data.sum_products, function(i,v){
                        $sumProduct += `<tr class="datatable-row" style="left: 0px;">
                                            <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.product_name +`</span></td>
                                            <td class="datatable-cell" style="width: 30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.qty +`</span></td>
                                        </tr>`
                    })
                    $('#count-product').html($countProduct)
                    $('#sum-products').html($sumProduct)
                }
            })
        }
        getStast($('#date_range input').val())
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>