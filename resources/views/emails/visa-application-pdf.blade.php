<!-- resources/views/emails/visa-application-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 180px;
            height: auto;
        }
        .application-title {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
        }
        .section-title {
            background: #f0f0f0;
            padding: 8px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .document-list {
            padding-left: 20px;
        }
        .document-list li {
            margin-bottom: 8px;
        }
        .disclaimer {
            font-size: 12px;
            color: #666;
            padding: 15px;
            background: #f8f9fa;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .label {
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('assets/img/logo.png') }}" class="logo" alt="Company Logo">
        </div>
        <div class="application-title">{{ $visaApplication->visa->visaCountry->name }} VISA APPLICATION</div>
        {{-- <p>Application Reference: {{ $visaApplication->id }}</p> --}}
    </div>

    <div class="section">
        <div class="section-title">Application Details</div>
        <table>
            <tr>
                <td class="label">Visa Type</td>
                <td>{{ $visaApplication->visa->visaType->name }}</td>
            </tr>
            <tr>
                <td class="label">Processing Time</td>
                <td>{{ $visaApplication->visa->processing_time }} days</td>
            </tr>
            <tr>
                <td class="label">Stay Period</td>
                <td>{{ $visaApplication->visa->stay_period }} days</td>
            </tr>
            <tr>
                <td class="label">Validity</td>
                <td>{{ $visaApplication->visa->validity }} days</td>
            </tr>
            <tr>
                <td class="label">Entry Type</td>
                <td>{{ ucfirst($visaApplication->visa->entry) }}</td>
            </tr>
            <tr>
                <td class="label">Visa Fees</td>
                <td>{{ number_format($visaApplication->visa->fee, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Travel Date</td>
                <td>{{ $visaApplication->travel_date }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Applicant Information</div>
        <table>
            <tr>
                <td class="label">Name</td>
                <td>{{ $visaApplication->salutation }} {{ $visaApplication->first_name }} {{ $visaApplication->last_name }}</td>
            </tr>
            <tr>
                <td class="label">Type</td>
                <td>{{ $visaApplication->type }}</td>
            </tr>
            <tr>
                <td class="label">Mobile</td>
                <td>{{ $visaApplication->mobile }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $visaApplication->email }}</td>
            </tr>
            @if($visaApplication->pancard)
            <tr>
                <td class="label">PAN Card</td>
                <td>{{ $visaApplication->pancard }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="section">
        <div class="section-title">Required Documents</div>
        <div class="document-list">
            {!! $visaApplication->visa->visaCountry->documents_required !!}
        </div>
    </div>

    <div class="disclaimer">
        <h3>Important Disclaimer</h3>
        {!! $visaApplication->description !!}

    </div>
</body>
</html>