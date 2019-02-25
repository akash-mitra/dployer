@extends('layouts.app')


@section('page.css')

    <style>
        .StripeElement {
            background-color: #f1f5f8;
            height: 40px;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endsection

@section('content')
<div class="flex items-center h-full">
    <div class="md:w-3/4 md:mx-auto">

        <div class="flex justify-between flex-wrap">
            <div class="font-serif text-2xl text-grey-darker  p-3">
                Let's get started
                <span class="text-grey text-base">
                    &dash; with a dedicated SSD server highly optimized for Platonics
                </span>
            </div>

            <!-- <div class="text-sm text-grey-darker p-3">
                    <button class="bg-grey-lighter border hover:bg-grey-light text-grey-dark  py-2 px-4 rounded-full" id="btnCreateNew">
                        Cancel
                    </button>
            </div> -->
        </div>
        

        <div class="rounded border shadow">
            
            <div class="flex h-full bg-blue rounded-b">        
                    <div class="w-2/3 p-6 bg-white min-h-full">

                        
                    
                        <form action="{{ route('subscribe-user') }}" method="post" id="payment-form">

                            {{ csrf_field() }}

                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                            @if ($errors->any())
                                <div class="mb-6 p-4 bg-orange-lightest text-orange-dark">
                                    <ul class="list-reset">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                            Blog Name
                                        </label>
                                        <input name="blogName" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-blog-name" type="text" placeholder="e.g. Himalayan Cuisine">
                                        <p class="text-grey-dark text-xs italic">Make it sweet, succinct or as crazy as you'd like</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                            Description
                                        </label>
                                        <textarea name="blogDesc" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-blog-desc" placeholder="e.g. a blog about authentic North Bengal cuisine"></textarea>
                                        <p class="text-grey-dark text-xs italic">This is how your blog is going to be introduced to search engine crawlers. Make it to the point.</p>
                                    </div>
                                </div>

                                @if(! $subscribed)
                                <input type="hidden" name="subscribed" value="no">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="card-element">
                                            Add Card
                                        </label>
                                        <div id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                        </div>
                                        <!-- Used to display form errors. -->
                                        <div id="card-errors" class="my-3 text-orange-dark text-xs" role="alert"></div>
                                        <p class="text-grey-dark text-xs italic">Use Visa, Master Or American Express Credit Card.</p>
                                    </div>
                                </div>
                                @else
                                    <input type="hidden" name="subscribed" value="yes">
                                @endif
                                
                            </div>
                            <button class="bg-teal-light shadow hover:shadow-none hover:bg-green text-white rounded py-2 px-4" id="btnCreateNew">
                                Start My Blog
                            </button>
                        </form>



                    </div>
                    <div class="w-1/3 p-4 md:p-6 font-sans text-white h-full">
                        <blockquote class="font-serif text-2xl text-blue-lightest">
                            Fill your paper with the breathings of your heart. 
                        </blockquote>
                        
                        <p class="mt-2 mb-6 text-sm text-blue-light text-right">
                            - William Wordsworth
                        </p>

                        <p class="mt-6 pt-2 font-sans text-blue-lighter">
                            Platonics provide you tools and technologies to
                            help you create truly amazing blogs. 
                        </p>

                        <ul class="list-reset my-6 text-xs text-blue-lightest">
                            <li class="my-2 "><i class="fa fa-plus"></i>SSL enabled dedicated servers</li>
                            <li class="my-2 "><i class="fa fa-plus"></i>Integrated Social Authentication</li>
                            <li class="my-2 "><i class="fa fa-plus"></i>Advanced Commenting System</li>
                            <li class="my-2 "><i class="fa fa-plus"></i>Full Monetization Support</li>
                        </ul>

                        <p class="text-blue-lightest">
                            <span class="text-xs">USD</span>
                            <span class="text-3xl">9</span>
                            <span class="text-xs"> / month. Cancel any time.</span>
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('page.script')
@if(! $subscribed)
<script src="https://js.stripe.com/v3/"></script>

<script>
    // Create a Stripe client.
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');



    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });



    // Handle form submission.
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });


    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

</script>
@endif
@endsection
