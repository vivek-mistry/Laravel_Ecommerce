@extends('components.front-end.front-end-layout')

@section('styles')
    <style>
        .hosted-field {
            height: 50px;
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            display: inline-block;
            box-shadow: none;
            font-weight: 500;
            font-size: 14px;
            border-radius: $radius-default;
            border: 1px solid #dddddd;
            line-height: 20px;
            background: #fcfcfc;
            margin-bottom: 12px;
            background: linear-gradient(to right, white 50%, #fcfcfc 50%);
            background-size: 200% 100%;
            background-position: right bottom;
            transition: all 300ms ease-in-out;
        }

        .hosted-fields--label {
            font-family: courier, monospace;
            text-transform: uppercase;
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        }

        .button-container {
            display: block;
            text-align: center;
        }

        .braintree-hosted-fields-focused {
            border: 1px solid #64d18a;
            border-radius: $radius-default;
            background-position: left bottom;
        }

        .braintree-hosted-fields-invalid {
            border: 1px solid #ed574a;
        }

        .braintree-hosted-fields-valid {}

        #cardForm {
            max-width: 50.75em;
            margin: 0 auto;
            padding: 1.875em;
        }
    </style>
@endsection

@section('contents')
    <div class="container">
        <div class="row my-5 py-lg-5">
            <div id="paypal-button-container">

            </div>
            <div class="demo-frame">
                <form action="/" method="post" id="cardForm">
                    <label class="hosted-fields--label" for="card-number">Card Number</label>
                    <div id="card-number" class="hosted-field"></div>

                    <label class="hosted-fields--label" for="expiration-date">Expiration Date</label>
                    <div id="expiration-date" class="hosted-field"></div>

                    <label class="hosted-fields--label" for="cvv">CVV</label>
                    <div id="cvv" class="hosted-field"></div>

                    <label class="hosted-fields--label" for="cvv">Postal Code</label>
                    <div id="postal-code" class="hosted-field"></div>

                    <div class="button-container">
                        <input type="submit" class="button button--small button--green" value="Purchase" id="submit" />
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('insider-page')
    @include('components.front-end.common.insider-footer')
@endsection

@section('scripts')
    <!-- CUSTOM CODE -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=ATrLhEVW4gmEfRsSEwkdxe_0q8FjWt1bBu11SHwwjc12vEKGgbR32cziBbK0rmtnhJsgDH2M1xWbAgl7&components=buttons,hosted-fields">
    </script>
    <script>
        const paypal_init = paypal;

        console.log("paypal.FUNDING => ", paypal.FUNDING);
        paypal_init.HostedFields.isEligible();

        if (paypal_init.HostedFields.isEligible()) {
            paypal_init.HostedFields.render({
                createOrder: (data, actions) => {
                    // pass in any options from the v2 orders create call:
                    // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                    const createOrderPayload = {
                        purchase_units: [{
                            amount: {
                                value: '88.44',
                            },
                        }]

                    }

                    return actions.order.create(createOrderPayload)
                },

                // set up the transaction

                // finalize the transaction
                onApprove: (data, actions) => {
                    const captureOrderHandler = (details) => {
                        const payerName = details.payer.name.given_name
                        console.log('Transaction completed!')
                    }

                    return actions.order.capture().then(captureOrderHandler)
                },

                // handle unrecoverable errors
                onError: (err) => {
                    console.error(
                        'An error prevented the buyer from checking out with PayPal',
                    )
                },

                styles: {
                    'input': {
                        'font-size': '16pt',
                        'color': '#3A3A3A'
                    },
                    '.number': {
                        'font-family': 'monospace'
                    },
                    '.valid': {
                        'color': 'green'
                    }
                },
                fields: {
                    number: {
                        selector: '#card-number'
                    },
                    cvv: {
                        selector: '#cvv',
                        placeholder: '•••'
                    },
                    expirationDate: {
                        selector: '#expiration-date'
                    }
                },
            });
        } else {
            console.log('The funding source is ineligible')
        }

        console.log("paypal_init => ", paypal_init)
    </script>
    <!-- END CUSTOM CODE -->


    <!-- WORKING CODE -->
    {{-- <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"
        data-sdk-integration-source="integrationbuilder"></script> --}}

    <script>
        // 
        /*const fundingSources = [
            // paypal.FUNDING.PAYPAL,
            // paypal.FUNDING.VENMO,
            // paypal.FUNDING.PAYLATER,
            paypal.FUNDING.CARD
        ]

        for (const fundingSource of fundingSources) {
            const paypalButtonsComponent = paypal.Buttons({
                fundingSource: fundingSource,

                // optional styling for buttons
                // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
                style: {
                    shape: 'rect',
                    height: 40,
                },


                // set up the transaction
                createOrder: (data, actions) => {
                    // pass in any options from the v2 orders create call:
                    // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                    const createOrderPayload = {
                        purchase_units: [{
                            amount: {
                                value: '88.44',
                            },
                        }],
                        application_context: {
                            shipping_preference: 'NO_SHIPPING'
                        },

                    }

                    return actions.order.create(createOrderPayload)
                },

                // finalize the transaction
                onApprove: (data, actions) => {
                    const captureOrderHandler = (details) => {
                        const payerName = details.payer.name.given_name
                        console.log('Transaction completed!')
                    }

                    return actions.order.capture().then(captureOrderHandler)
                },

                // handle unrecoverable errors
                onError: (err) => {
                    console.error(
                        'An error prevented the buyer from checking out with PayPal',
                    )
                },
            })

            // paypalButtonsComponent.isEligible();
            // paypalButtonsComponent.render({
            //     styles: {
            //         'input': {
            //             'font-size': '16pt',
            //             'color': '#3A3A3A'
            //         },
            //         '.number': {
            //             'font-family': 'monospace'
            //         },
            //         '.valid': {
            //             'color': 'green'
            //         }
            //     },
            //     fields: {
            //         number: {
            //             selector: '#card-number'
            //         },
            //         cvv: {
            //             selector: '#cvv',
            //             placeholder: '•••'
            //         },
            //         expirationDate: {
            //             selector: '#expiration-date'
            //         }
            //     }
            // })
            if (paypalButtonsComponent.isEligible()) {
                paypalButtonsComponent
                    .render('#paypal-button-container')
                    .catch((err) => {
                        console.error('PayPal Buttons failed to render')
                    })
            } else {
                console.log('The funding source is ineligible')
            }
        }*/
    </script>
@endsection
