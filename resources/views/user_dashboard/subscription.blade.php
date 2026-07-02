@extends('layouts.app')

@section('title', 'Subscription Plan')

@section('assets')
    <style type="text/css">
        .card-pricing.popular {
        z-index: 1;
        border: 2px solid #396871;
        }
        .card-pricing .list-unstyled li {
        padding: .5rem 0;
        color: #6c757d;
        }
        .template_color{
            background-color: #396871;
        }
        .pricing_text_color{
            color: #396871;
        }

    </style>

@endsection

@section('scripts_first')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
@endsection


{{-- https://dashboard.flutterwave.com/signup --}}
{{-- currency: "{{ env('RAVE_CURRENCY')}}", --}}
{{-- url:"/process/subscription/" +subscription+"/check/{{Auth::user()->id}}", --}}


@section('content')

<div class="container mb-1 mt-customised">
    <h1 class="text-muted text-center mb-3">Downloads are not available</h1>
    <div class="pricing card-deck flex-column flex-md-row mb-3">
        {{-- STARTER --}}
        @foreach($subscriptions as $subscription)
            <div class="card card-pricing text-center px-3 mb-4">
                <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom template_color text-white shadow-sm">{{ $subscription->type }}</span>
                <div class="bg-transparent card-header pt-4 border-0">
                    <h1 class="h1 font-weight-normal pricing_text_color text-center mb-0" data-pricing-value="15">Gh<span class="price">{{$subscription->price}}</span></h1>
                </div>
                <div class="card-body pt-0">
                    <ul class="list-unstyled mb-4">
                        <li>{{$subscription->general_notes}}</li>
                        <li>{{$subscription->specific_notes}}</li>
                    </ul>
                    {{-- <button type="button" class="btn btn-outline-secondary mb-3" onClick="makePayment({{$subscription->id}}, {{$subscription->price}})">Subscribe</button> --}}
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function makePayment(subscription, amount) {
            var name = '{{ Auth::user()->name }}';
            var email = '{{ Auth::user()->email }}';
            var phone = '{{ Auth::user()->phone }}';

            FlutterwaveCheckout({
            public_key: "FLWPUBK-8f9fbb57646670b5149ef0af2fd24834-X",
            //local key
            // public_key: "FLWPUBK_TEST-504cb06bb23964c64b49447c1ea7fd50-X",
            tx_ref: "hooli-tx-1920bbtyt",
            amount: amount,
            currency:"GHS",
            payment_options: "card,mobilemoney,ussd",
            meta: {
                consumer_id: "{{ Auth::user()->id }}",
                consumer_mac: "92a3-912ba-1192a",
            },
            customer: {
                email:email,
                phone_number: phone,
                name: name,
            },
            callback: function (data) {
                console.log(data);

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"/process/" +subscription,
                type:'GET',
                success:function(data){
                    //redirect to articles page
                    window.location.href = "/";
                    alert('Your subscription Package is activated');
                },
                error: function(){
                    //do something when there is an error
                    alert('Something went wrong. Please try again');
                },
            });
            },
            customizations: {
                title: "My package",
                description: "Payment for items in cart",
                // logo: "https://assets.piedpiper.com/logo.png",
                // logo: "{{ asset('/logo/lawsghlog.png') }}"
            },
            });
        }
    </script>
@endsection
