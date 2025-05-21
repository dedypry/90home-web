@extends('web.layouts.base-layout')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary py-5">
    <div class="container py-5">
        <div class="row align-items-center py-4">
            <div class="col-md-6 text-center text-md-left">
                <h1 class="mb-4 mb-md-0 text-primary text-uppercase">Our Projects</h1>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <div class="d-inline-flex align-items-center">
                    <a class="btn btn-outline-primary" href="">Home</a>
                    <i class="fas fa-angle-double-right text-primary mx-2"></i>
                    <a class="btn btn-outline-primary disabled" href="">Our Projects</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header Start -->
<!-- Projects Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col text-center mb-4">
                <h6 class="text-primary font-weight-normal text-uppercase mb-3">Our Projects</h6>
                <h1 class="mb-4">Some Of Our Awesome Interior Designing Projects</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center mb-2">
                <ul class="list-inline mb-4" id="portfolio-flters">
                    <li class="btn btn-outline-primary m-1 active" data-filter="*">All</li>
                    <li class="btn btn-outline-primary m-1" data-filter=".first">Complete</li>
                    <li class="btn btn-outline-primary m-1" data-filter=".second">Running</li>
                    <li class="btn btn-outline-primary m-1" data-filter=".third">Upcoming</li>
                </ul>
            </div>
        </div>
        <div class="row mx-1 portfolio-container">
            <div class="col-lg-4 col-md-6 col-sm-12 p-0 portfolio-item first">
                <div class="position-relative overflow-hidden">
                    <div class="portfolio-img d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="img/portfolio-1.jpg" alt="">
                    </div>
                    <div
                        class="portfolio-text bg-secondary d-flex flex-column align-items-center justify-content-center">
                        <h4 class="text-white mb-4">Project Name</h4>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-outline-primary m-1" href="">
                                <i class="fa fa-link"></i>
                            </a>
                            <a class="btn btn-outline-primary m-1" href="img/portfolio-1.jpg" data-lightbox="portfolio">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 p-0 portfolio-item second">
                <div class="position-relative overflow-hidden">
                    <div class="portfolio-img d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="img/portfolio-2.jpg" alt="">
                    </div>
                    <div
                        class="portfolio-text bg-secondary d-flex flex-column align-items-center justify-content-center">
                        <h4 class="text-white mb-4">Project Name</h4>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-outline-primary m-1" href="">
                                <i class="fa fa-link"></i>
                            </a>
                            <a class="btn btn-outline-primary m-1" href="img/portfolio-2.jpg" data-lightbox="portfolio">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 p-0 portfolio-item third">
                <div class="position-relative overflow-hidden">
                    <div class="portfolio-img d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="img/portfolio-3.jpg" alt="">
                    </div>
                    <div
                        class="portfolio-text bg-secondary d-flex flex-column align-items-center justify-content-center">
                        <h4 class="text-white mb-4">Project Name</h4>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-outline-primary m-1" href="">
                                <i class="fa fa-link"></i>
                            </a>
                            <a class="btn btn-outline-primary m-1" href="img/portfolio-3.jpg" data-lightbox="portfolio">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 p-0 portfolio-item first">
                <div class="position-relative overflow-hidden">
                    <div class="portfolio-img d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="img/portfolio-4.jpg" alt="">
                    </div>
                    <div
                        class="portfolio-text bg-secondary d-flex flex-column align-items-center justify-content-center">
                        <h4 class="text-white mb-4">Project Name</h4>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-outline-primary m-1" href="">
                                <i class="fa fa-link"></i>
                            </a>
                            <a class="btn btn-outline-primary m-1" href="img/portfolio-4.jpg" data-lightbox="portfolio">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 p-0 portfolio-item second">
                <div class="position-relative overflow-hidden">
                    <div class="portfolio-img d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="img/portfolio-5.jpg" alt="">
                    </div>
                    <div
                        class="portfolio-text bg-secondary d-flex flex-column align-items-center justify-content-center">
                        <h4 class="text-white mb-4">Project Name</h4>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-outline-primary m-1" href="">
                                <i class="fa fa-link"></i>
                            </a>
                            <a class="btn btn-outline-primary m-1" href="img/portfolio-5.jpg" data-lightbox="portfolio">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 p-0 portfolio-item third">
                <div class="position-relative overflow-hidden">
                    <div class="portfolio-img d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="img/portfolio-6.jpg" alt="">
                    </div>
                    <div
                        class="portfolio-text bg-secondary d-flex flex-column align-items-center justify-content-center">
                        <h4 class="text-white mb-4">Project Name</h4>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-outline-primary m-1" href="">
                                <i class="fa fa-link"></i>
                            </a>
                            <a class="btn btn-outline-primary m-1" href="img/portfolio-6.jpg" data-lightbox="portfolio">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Projects End -->

@endsection
