@extends('client.layout')


@section('title')
    Contact
@endsection


@section('main')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Contact</h2>
        </div>

        <div class="untree_co-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <form class="contact-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black" for="fname">First name</label>
                                <input type="text" class="form-control" id="fname">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black" for="lname">Last name</label>
                                <input type="text" class="form-control" id="lname">
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="text-black" for="email">Email address</label>
                            <input type="email" class="form-control" id="email">
                            </div>

                            <div class="form-group">
                            <label class="text-black" for="message">Message</label>
                            <textarea name="" class="form-control" id="message" cols="30" rows="5"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                    <div class="col-lg-5 ml-auto">
                    <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-house"></span>
                        <address class="text">
                        155 Market St #101, Paterson, NJ 07505, United States
                        </address>
                    </div>
                    <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-phone-call"></span>
                        <address class="text">
                        +1 202 2020 200
                        </address>
                    </div>
                    <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-mail"></span>
                        <address class="text">
                        @info@mydomain.com
                        </address>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
