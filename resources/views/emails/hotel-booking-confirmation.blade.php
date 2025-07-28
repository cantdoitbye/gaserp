<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; background-color: #f4f4f4; }
        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0; }
        .header { background-color: #4CAF50; color: white; text-align: center; padding: 20px; border-radius: 8px 8px 0 0; }
        h1 { margin: 0; font-size: 24px; }
        .info-box { background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 4px; padding: 15px; margin-bottom: 20px; }
        .room-info { margin-bottom: 10px; }
        .footer { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; font-size: 12px; color: #666; }
        .footer a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Your Hotel Booking is Confirmed!</h1>
        </header>

        <main>
            <p>Dear {{ $user->name }},</p>
            <p>We are pleased to inform you that your hotel booking has been confirmed. Here are the details of your booking:</p>

            <div class="info-box">
                <h3>Hotel Information</h3>
                <p><strong>Hotel Name:</strong> {{ $hotel['hotel_name'] }}</p>
                <p><strong>City:</strong> {{ $hotel['city'] }}</p>
                <p><strong>Arrival Date:</strong> {{ $hotel['arrival_date'] }}</p>
                <p><strong>Departure Date:</strong> {{ $hotel['departure_date'] }}</p>
            </div>

            <h3>Room Information</h3>
            @foreach ($rooms as $room)
            <div class="room-info">
                <p><strong>Room Type:</strong> {{ $room['type'] }}</p>
                <p><strong>Adults:</strong> {{ $room['adults'] }}</p>
                <p><strong>Children:</strong> {{ $room['children'] }}</p>
                <p><strong>Total Rooms:</strong> {{ $room['total_rooms'] }}</p>
                <p><strong>Total Rate:</strong> {{ $room['total_rate'] }}</p>
            </div>
            @endforeach

            <div class="info-box">
                <h3>Payment Information</h3>
                <p><strong>Payment ID:</strong> {{ $payment }}</p>
            </div>

            <p>If you have any questions or need further assistance, feel free to contact us.</p>

            <p>Thank you for booking with us!</p>
        </main>

        <footer class="footer">
            <p>&copy; 2024 Happy Holidays. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
