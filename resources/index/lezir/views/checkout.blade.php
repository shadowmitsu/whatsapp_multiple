<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset_index('images/favicon.png') }}">
    <title>{{__('Checkout')}}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset_index('css/bootstrap.' . (in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr') . '.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #f4f6f9;
            --text-color: #2c3e50;
            --card-background: #ffffff;
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, var(--background-color) 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Inter', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 600px;
            padding: 1rem;
        }

        .payment-container {
            background-color: #e9f7fc;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.07);
            padding: 2.5rem;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
        }

        .card-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
            margin: 0.5rem auto;
            border-radius: 2px;
        }

        .plan-price {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .form-select {
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            background-color: #e0f0f7;
            border: 1px solid #ced4da;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.4s ease;
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.3);
            background-color: #2980b9;
        }

        .error-container {
            background-color: #ffebee;
            color: #c62828;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .gateway-title {
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 576px) {
            .payment-container {
                padding: 1.5rem;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="payment-container">
            @if ($errors->any())
            <div class="error-container">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="text-break">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <h3 class="card-title">{{ $plan->title }}</h3>
            <h3 class="plan-price">{{ $plan->symbol }} {{ number_format($plan->price) }}</h3>
            
            <h3 class="gateway-title">{{ __('Select Payment Gateway') }}</h3>
            
            <form action="{{ route('payments.process', ['planId' => $plan->id]) }}" method="POST">
                @csrf
                <select name="payment_gateway" class="form-select" required>
                    @foreach ($gateways as $key => $gateway)
						@if($gateway['status'] == "enable")
							@if($key == "custom")
								<option value="{{ $key }}">
									<i class="fas fa-credit-card me-2"></i> {{ ucfirst($gateway['title']) }}
								</option>
							@else
								<option value="{{ $key }}">
									<i class="fas fa-credit-card me-2"></i> {{ ucfirst($key) }}
								</option>
							@endif
						@else
						@endif
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-arrow-right me-2"></i>
                    {{ __('Proceed to Payment') }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>