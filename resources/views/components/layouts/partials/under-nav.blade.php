<div class="container-fluid bg-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 text-left mb-3 mb-lg-0">
                <div class="d-inline-flex text-left">
                    <h1 class="flaticon-office font-weight-normal text-primary m-0 mr-3"></h1>
                    <div class="d-flex flex-column">
                        <h5>Our Office</h5>
                        <p class="m-0">{{$app->address}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-left text-lg-center mb-3 mb-lg-0">
                <div class="d-inline-flex text-left">
                    <h1 class="flaticon-email font-weight-normal text-primary m-0 mr-3"></h1>
                    <div class="d-flex flex-column">
                        <h5>Email Us</h5>
                        <p class="m-0">{{$app->email}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-left text-lg-right mb-3 mb-lg-0">
                <div class="d-inline-flex text-left">
                    <h1 class="flaticon-telephone font-weight-normal text-primary m-0 mr-3"></h1>
                    <div class="d-flex flex-column">
                        <h5>Call Us</h5>
                        <p class="m-0">{{$app->phone}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
