@extends('admin.layouts.app')
@section('title','Ticket Verify')

<style>
    #qr-reader {
        width: 100%;
        height: 400px;
        margin-top: 20px;
        border: 2px solid #ccc;
    }
    #scan-result {
        margin-top: 20px;
    }
    #booking-details {
    margin-top: 20px;
    text-align: left;
}
#qr-reader__dashboard_section_swaplink {
    display: inline-block;
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
    border: none;
}

#qr-reader__dashboard_section_swaplink:hover {
    background-color: #0056b3;
}
input[type="button"], input[type="submit"], button {
    padding: 10px 16px;
    background-color: #28a745;
    color: white;
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
    border: none;
    cursor: pointer;
}
</style>

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card mt-3">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Ticket Verify
                    </div>
                </div>
                <div class="card-body">
                    <div style="text-align: center;">
                        <h2>QR Code Scanner</h2>
                        <div id="qr-reader"></div>
                        <div id="scan-result">
                            <p><strong>Scanned Data:</strong></p>
                            <p id="scanned-data">No QR code scanned yet.</p>
                        </div>
                        <div id="booking-details" style="margin-top: 20px;">
                            <h3>Booking Details</h3>
                            <p><strong>Contact No:</strong> <span id="contact-number"></span></p>
                            <p><strong>Departure:</strong> <span id="departure-station"></span></p>
                            <p><strong>Destination:</strong> <span id="destination-station"></span></p>
                            <p><strong>Train Name:</strong> <span id="train-name"></span></p>
                            <p><strong>Seat No:</strong> <span id="seat-number"></span></p>
                            <p><strong>Date & Time:</strong> <span id="departure-time"></span></p>
                            <p><strong>Status:</strong> <span id="ticket-status" class="badge rounded-pill bg-primary"></span></p>
                            <button id="verify-ticket" class="btn btn-success" style="display: none;">Verify Ticket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>

<script type="text/javascript">
    let scannedTicketId = null;

    window.onload = function () {
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById("scanned-data").innerText = 'Scanned';
            scannedTicketId = decodedText;

            $.ajax({
                url: `ticket-verification/${decodedText}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('data', data);

                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#booking-id').text(data.id);
                        $('#contact-number').text(data.phone_number);
                        $('#departure-station').text(data.fromStation);
                        $('#destination-station').text(data.toStation);
                        $('#train-name').text(data.train);
                        $('#seat-number').text(data.seat);
                        $('#departure-time').text(data.date);
                        $('#ticket-status').text(data.verified ? "Verified" : "Not Verified");

                        if (!data.verified) {
                            $('#verify-ticket').show();
                        } else {
                            $('#verify-ticket').hide();
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching booking data:', error);
                }
            });
        }

        function onScanError(errorMessage) {
            console.log(errorMessage);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            {
                fps: 10,
                qrbox: 250
            }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanError);

        $('#verify-ticket').click(function () {
            if (scannedTicketId) {
                $.ajax({
                    url: `ticket-verify/${scannedTicketId}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        verified: 1
                    },
                    success: function (response) {
                        $('#ticket-status').text("Verified");
                        $('#verify-ticket').hide();
                        setTimeout(function() {
        location.reload();
    }, 5000);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error verifying ticket:', error);
                    }
                });
            }
        });
    };
</script>


@endsection
