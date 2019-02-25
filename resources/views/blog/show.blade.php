@extends('layouts.app')


@section('page.css')

    <style>
        
    </style>
@endsection

@section('content')
<div class="flex items-center h-full">
    <div class="md:w-3/4 md:mx-auto">

        <div class="flex justify-between flex-wrap">
            <div class="font-serif text-2xl text-grey-darker  p-3">
                Himalayan Foot Hills
                <span class="text-grey text-base">
                    North Bengal Food Fiesta
                </span>    
            </div>
            

            <!-- <div class="text-sm text-grey-darker p-3">
                    <button class="bg-grey-lighter border hover:bg-grey-light text-grey-dark  py-2 px-4 rounded-full" id="btnCreateNew">
                        Cancel
                    </button>
            </div> -->
        </div>
        

        <div class="rounded border shadow">
            
            <div class="flex h-full bg-grey-lighter rounded-b">        
                    <div class="w-2/3 p-6 bg-white min-h-full">
                    
                            The man

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
@endsection
