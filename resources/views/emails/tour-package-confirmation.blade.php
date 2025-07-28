{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Happy Holidays</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; background-color: #f4f4f4; }
        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0; }
        .header { background-color: #4CAF50; color: white; text-align: center; padding: 20px; border-radius: 8px 8px 0 0; }
        .logo { max-width: 150px; height: auto; margin-bottom: 10px; }
        h1 { margin: 0; font-size: 24px; }
        .info-box { background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 4px; padding: 15px; margin-bottom: 20px; }
        .info-box h3 { color: #4CAF50; margin-top: 0; }
        .traveler-info { background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 4px; padding: 10px; margin-bottom: 10px; }
        .footer { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; font-size: 12px; color: #666; }
        .footer a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <img src="https://gitcsdemoserver.online/hholidays/public/assets/img/logo.png" alt="Happy Holidays Logo" class="logo">
            <h1>Your Booking is Confirmed!</h1>
        </header>

        <main>
            <p>Dear {{ $customerName }}, here are the details of your exciting journey:</p>

            <div style="display: flex; justify-content: space-between;">
                <div class="info-box" style="width: 48%;">
                    <h3>Booking Information</h3>
                    <p><strong>Booking ID:</strong> {{ $bookingId }}</p>
                    <p><strong>Tour Name:</strong> {{ $tourName }}</p>
                    <p><strong>Destination:</strong> {{ $destination }}</p>
                    <p><strong>Tour Type:</strong> {{ $tourType }}</p>
                    <p><strong>Duration:</strong> {{ $days }} Days and {{ $nights }} Nights</p>
                </div>
                <div class="info-box" style="width: 48%;">
                    <h3>Payment Information</h3>
                    <p><strong>Total Amount Paid:</strong> ${{ $amount }}</p>
                    <p><strong>Payment Method:</strong> {{ $paymentMethod }}</p>
                    <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
                </div>
            </div>

            <h3 style="color: #4CAF50;">Traveler Information</h3>
            @foreach ($travelers as $traveler)
            <div class="traveler-info">
                {{ $traveler->salutation }} {{ $traveler->first_name }} {{ $traveler->last_name }} ({{ ucfirst($traveler->type) }})
            </div>
            @endforeach

        <section style="margin: 20px 0;">
            <h3 style="color: #4CAF50;">Detailed Itinerary</h3>
            @foreach ($daysData as $day)
            <div style="margin-bottom: 20px; background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
                <h4 style="color: #4CAF50; margin-top: 0;">Day {{ $day->day_order }}: {{ $day->day_title }}</h4>
                @if($day->hotel_name)
                    <p><strong>Hotel:</strong> {{ $day->hotel_name }}</p>
                @endif
                @if($day->sight_seeing)
                    <p><strong>Sightseeing:</strong> {{ $day->sight_seeing }}</p>
                @endif
                @if($day->included)
                    <p><strong>Included:</strong> {{ $day->included }}</p>
                @endif
                <p>{{ $day->day_details }}</p>
                @if($day->day_image)
                    <img src="{{ $day->day_image }}" alt="Day {{ $day->day_order }} Image" style="max-width: 100%; margin-top: 10px;">
                @endif
            </div>
            @endforeach
        </section>

        @if(count($images) > 0)
        <section style="margin: 20px 0;">
            <h3 style="color: #4CAF50;">Tour Images</h3>
            @foreach ($images as $image)
            <img src="{{asset('/uploads')}}/{{ $image->image_thumb }}" alt="{{ $image->alt_text }}" style="max-width: 100%; margin-bottom: 10px;">
            @endforeach
        </section>
        @endif

        <section style="margin: 20px 0;">
            <h3 style="color: #4CAF50;">What's Next?</h3>
            <p>Our team will contact you shortly with more detailed information about your trip. If you have any questions, please don't hesitate to reach out to us.</p>
            <p>We're excited to help you create unforgettable memories!</p>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Happy Holidays. All rights reserved.</p>
        <p>
            <a href="#">Website</a> |
            <a href="#">Contact Us</a> |
            <a href="#">Terms and Conditions</a>
        </p>
    </footer>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Happy Holidays</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; background-color: #f4f4f4; }
        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0; }
        .header { background-color: #4CAF50; color: white; text-align: center; padding: 20px; border-radius: 8px 8px 0 0; }
        .logo { max-width: 150px; height: auto; margin-bottom: 10px; }
        h1 { margin: 0; font-size: 24px; }
        .info-box { background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 4px; padding: 15px; margin-bottom: 20px; }
        .info-box h3 { color: #4CAF50; margin-top: 0; }
        .room-info { background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 4px; padding: 10px; margin-bottom: 10px; }
        .footer { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; font-size: 12px; color: #666; }
        .footer a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <img src="https://gitcsdemoserver.online/hholidays/public/assets/img/logo.png" alt="Happy Holidays Logo" class="logo">
            <h1>Your Booking is Confirmed!</h1>
        </header>

        <main>
            <p>Dear {{ $user->name }}, here are the details of your exciting journey:</p>

            <div style="display: flex; justify-content: space-between;">
                <div class="info-box" style="width: 48%;">
                    <h3>Booking Information</h3>
                    <p><strong>Booking ID:</strong> {{ $booking->id ?? 'N/A' }}</p>
                    <p><strong>Tour Name:</strong> {{ $tour->tour_name ?? 'N/A' }}</p>
                    <p><strong>Destination:</strong> {{ $tour->destination->name ?? 'N/A' }}</p>
                    <p><strong>Tour Type:</strong> {{ $tour->tourtype->name ?? 'N/A' }}</p>
                    <p><strong>Duration:</strong> {{ $tour->number_of_days ?? '0' }} Days and {{ $tour->number_of_nights ?? '0' }} Nights</p>
                    <p><strong>Travel Date:</strong> {{ $travel_date ?? 'N/A' }}</p>
                </div>
                <div class="info-box" style="width: 48%;">
                    <h3>Payment Information</h3>
                    <p><strong>Total Amount Paid:</strong> Rs{{ number_format($payment->amount, 2) ?? '0.00' }}</p>
                    <p><strong>Payment Method:</strong> {{ $payment->payment_method ?? 'N/A' }}</p>
                    <p><strong>Transaction ID:</strong> {{ $payment->razorpay_payment_id ?? 'N/A' }}</p>
                </div>
            </div>

            <h3 style="color: #4CAF50;">Room Information</h3>
            @foreach ($rooms as $index => $room)
            <div class="room-info">
                <h4>Room {{ $index + 1 }}</h4>
                <p><strong>Adults:</strong> {{ $room->adults }}</p>
                <p><strong>Kids:</strong> {{ $room->kids }}</p>
                <p><strong>Infants:</strong> {{ $room->infants }}</p>
                @if($room->kids > 0 && is_array($room->extra_beds))
                <p><strong>Extra Beds:</strong> {{ implode(', ', $room->extra_beds) }}</p>
            @endif
            </div>
            @endforeach

            <div class="info-box">
                <h3>Contact Information</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone }}</p>
            </div>

            <section style="margin: 20px 0;">
                <h3 style="color: #4CAF50;">Detailed Itinerary</h3>
                @foreach ($tour->daysdata as $day)
                <div style="margin-bottom: 20px; background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
                    <h4 style="color: #4CAF50; margin-top: 0;">Day {{ $day->day_order }}: {{ $day->day_title }}</h4>
                    @if($day->hotel_name)
                        <p><strong>Hotel:</strong> {{ $day->hotel_name }}</p>
                    @endif
                    @if($day->sight_seeing)
                        <p><strong>Sightseeing:</strong> {{ $day->sight_seeing }}</p>
                    @endif
                    @if($day->included)
                        <p><strong>Included:</strong> {{ $day->included }}</p>
                    @endif
                    <p>{{ $day->day_details }}</p>
                    @if($day->day_image)
                        <img src="{{ $day->day_image }}" alt="Day {{ $day->day_order }} Image" style="max-width: 100%; margin-top: 10px;">
                    @endif
                </div>
                @endforeach
            </section>

            @if(count($tour->images) > 0)
            <section style="margin: 20px 0;">
                <h3 style="color: #4CAF50;">Tour Images</h3>
                @foreach ($tour->images as $image)
                <img src="{{ asset('/uploads') }}/{{ $image->image_thumb }}" alt="{{ $image->alt_text }}" style="max-width: 100%; margin-bottom: 10px;">
                @endforeach
            </section>
            @endif

            <section style="margin: 20px 0;">
                <h3 style="color: #4CAF50;">What's Next?</h3>
                <p>Our team will contact you shortly with more detailed information about your trip. If you have any questions, please don't hesitate to reach out to us.</p>
                <p>We're excited to help you create unforgettable memories!</p>
            </section>
        </main>

        <footer class="footer">
            <p>&copy; 2024 Happy Holidays. All rights reserved.</p>
            <p>
                <a href="#">Website</a> |
                <a href="#">Contact Us</a> |
                <a href="#">Terms and Conditions</a>
            </p>
        </footer>
    </div>
</body>
</html>