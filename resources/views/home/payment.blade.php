@extends('layout.home')

@section('title', 'Pembayaran')

@section('content')

    <div class="text-center mt-5">
        <div class="mb-4">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
        </div>

        <h3 class="fw-semibold">Memproses Pembayaran...</h3>
        <p class="text-muted">Jangan tutup atau refresh halaman ini.</p>
    </div>

@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        window.onload = function () {
            snap.pay("{{ $snapToken }}", {
                onSuccess: function(result){
                    window.location.href = "/reservasi/{{ Illuminate\Support\Str::lower($reservasi->order_id) }}";
                },
                onPending: function(result){
                    console.log("pending", result);
                },
                onError: function(result){
                    alert("Pembayaran gagal");
                }
            });
        }
    </script>
@endsection
