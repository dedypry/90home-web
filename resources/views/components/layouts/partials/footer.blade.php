<div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5">
    <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-primary mb-4">Get In Touch</h4>
            <p><i class="fa fa-map-marker-alt mr-2"></i>{{$app->address}}</p>
            <p><i class="fa fa-phone-alt mr-2"></i>{{$app->phone}}</p>
            <p><i class="fa fa-envelope mr-2"></i>{{$app->email}}</p>
            <div class="d-flex justify-content-start mt-4">
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 38px; height: 38px;"
                    href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-primary mb-4">Quick Links</h4>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white mb-2" href="{{route('home')}}"><i class="fa fa-angle-right mr-2"></i>Home</a>
                <a class="text-white mb-2" href="{{route('about')}}"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                <a class="text-white mb-2" href="{{route('service')}}"><i class="fa fa-angle-right mr-2"></i>Our Services</a>
                <a class="text-white mb-2" href="{{route('project')}}"><i class="fa fa-angle-right mr-2"></i>Our Projects</a>
                <a class="text-white" href="{{route('contact')}}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-primary mb-4">Popular Links</h4>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white mb-2" href="{{route('home')}}"><i class="fa fa-angle-right mr-2"></i>Home</a>
                <a class="text-white mb-2" href="{{route('about')}}"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                <a class="text-white mb-2" href="{{route('service')}}"><i class="fa fa-angle-right mr-2"></i>Our Services</a>
                <a class="text-white mb-2" href="{{route('project')}}"><i class="fa fa-angle-right mr-2"></i>Our Projects</a>
                <a class="text-white" href="{{route('contact')}}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h4 class="text-primary mb-4">Newsletter</h4>
            <form action="">
                <div class="form-group">
                    <input type="text" class="form-control border-0" placeholder="Your Name" required="required" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control border-0" placeholder="Your Email" required="required" />
                </div>
                <div>
                    <button class="btn btn-lg btn-primary btn-block border-0" type="submit">Submit Now</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container border-top border-secondary pt-5">
        <p class="m-0 text-center text-white">
            &copy; <a class="text-white font-weight-bold" href="#">Your Site Name</a>. All Rights Reserved.

            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            Designed by <a class="text-white font-weight-bold" href="https://dedypry.id">dedypry.id</a>
        </p>
    </div>
</div>
