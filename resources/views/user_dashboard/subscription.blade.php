@extends('layouts.user')

@section('title', 'Subscription Plan')

@section('styles')
    <script src="https://checkout.flutterwave.com/v3.js"></script>
@endsection

@section('content')
<div class="content-card">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 class="card-title" style="font-size: 28px;">Choose Your Subscription Plan</h1>
        <p class="card-subtitle" style="max-width: 600px; margin: 8px auto 0 auto; line-height: 1.6;">
            Get unlimited access to database search engines, legal preambles, and official PDF downloads.
        </p>
    </div>

    <!-- Pricing Grid -->
    <div class="pricing-grid">
        @foreach($subscriptions as $subscription)
            <div class="pricing-card">
                <div class="pricing-header">
                    <div class="plan-name">{{ $subscription->type }}</div>
                    <div class="plan-price">
                        <span style="font-size: 20px; font-weight: 600; vertical-align: top; color: var(--accent-color);">GHS</span>{{ $subscription->price }}
                    </div>
                    <span class="plan-duration">per package activation</span>
                </div>
                
                <ul class="plan-features">
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ $subscription->general_notes }}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ $subscription->specific_notes }}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Access PDF Downloads</span>
                    </li>
                </ul>

                <button type="button" class="btn-purchase" onclick="makePayment({{ $subscription->id }}, {{ $subscription->price }})">
                    Subscribe Now
                </button>
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
                tx_ref: "hooli-tx-" + Math.floor(Math.random() * 1000000000),
                amount: amount,
                currency: "GHS",
                payment_options: "card,mobilemoney,ussd",
                meta: {
                    consumer_id: "{{ Auth::user()->id }}",
                    consumer_mac: "92a3-912ba-1192a",
                },
                customer: {
                    email: email,
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
                        url: "/process/" + subscription,
                        type: 'GET',
                        success: function(data){
                            window.location.href = "/home";
                            alert('Your subscription package has been activated successfully!');
                        },
                        error: function(){
                            alert('Something went wrong during the activation. Please contact support.');
                        }
                    });
                },
                customizations: {
                    title: "LawsGhana Subscription",
                    description: "Payment for subscription plan: " + subscription,
                },
            });
        }
    </script>
@endsection
