@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4 py-8 bg-white rounded-xl shadow-lg" x-data="{ loading: false }">
    <div class="text-center mb-8">
        <div class="mb-6">
            <span class="text-4xl">💳</span>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Pembayaran Tagihan</h2>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-xl font-semibold text-blue-800 mb-2">
                {{ $payment->title }}
            </h3>
            <p class="text-2xl font-bold text-blue-600">
                Rp{{ number_format($payment->amount, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="flex justify-center">
        <button 
            id="pay-button" 
            @click="loading = true"
            :disabled="loading"
            class="inline-flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white font-bold py-4 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 disabled:transform-none disabled:cursor-not-allowed shadow-lg">
            <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <svg x-show="loading" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <span x-show="!loading">Bayar Sekarang</span>
            <span x-show="loading">Memproses...</span>
        </button>
    </div>

    {{-- Informasi tambahan --}}
    <div class="mt-8 text-center">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-center gap-2 text-yellow-800">
                <span class="text-lg">⚠️</span>
                <span class="text-sm">Pastikan Anda memiliki saldo yang cukup sebelum melakukan pembayaran</span>
            </div>
        </div>
    </div>
</div>

{{-- Load Midtrans Snap.js --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                console.log('Sukses:', result);
                window.location.href = "{{ route('midtrans.success') }}";
            },
            onPending: function (result) {
                console.log('Menunggu:', result);
                window.location.href = "{{ route('midtrans.success') }}";
            },
            onError: function (result) {
                console.error('Gagal:', result);
                window.location.href = "{{ route('midtrans.failed') }}";
            },
            onClose: function () {
                alert('Kamu menutup popup sebelum menyelesaikan pembayaran.');
            }
        });
    };
</script>
@endsection
