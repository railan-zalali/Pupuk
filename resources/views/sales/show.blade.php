<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Invoice Details') }} - {{ $sale->invoice_number }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('sales.invoice', $sale) }}" target="_blank"
                    class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print Invoice
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg print-container">
                <div class="p-6 text-gray-900">
                    <!-- Company Info (Visible when printing) -->
                    <div class="hidden print:block mb-8 text-center">
                        <h1 class="text-2xl font-bold">{{ config('app.name', 'Toko Pupuk') }}</h1>
                        <p>Jl. Contoh No. 123, Kota</p>
                        <p>Telp: (123) 456-7890</p>
                    </div>

                    <!-- Invoice Info -->
                    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Penjualan</h3>
                            <dl class="mt-4 space-y-2">
                                <div>
                                    <dt class="font-medium text-gray-500">No. Invoice</dt>
                                    <dd>{{ $sale->invoice_number }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Tanggal</dt>
                                    {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Status</dt>
                                    <dd>
                                        @if ($sale->trashed())
                                            <span
                                                class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                                Batal
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                                Berhasil
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Pembeli</h3>
                            <dl class="mt-4 space-y-2">
                                <div>
                                    <dt class="font-medium text-gray-500">Nama Pembeli</dt>
                                    <td class="px-6 py-4">{{ $sale->customer->nama ?? '-' }}</td>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Metode Pembayaran</dt>
                                    <dd class="capitalize">{{ $sale->payment_method }}</dd>
                                    @if ($sale->payment_method === 'credit')
                                        <div>
                                            <dt class="font-medium text-gray-500">Uang Muka (DP)</dt>
                                            <dd>Rp {{ number_format($sale->down_payment, 0, ',', '.') }}</dd>
                                        </div>
                                    @endif

                                    @if ($sale->payment_status !== 'paid')
                                        <div>
                                            <dt class="font-medium text-gray-500">Sisa Hutang</dt>
                                            <dd>Rp {{ number_format($sale->remaining_amount, 0, ',', '.') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-500">Jatuh Tempo</dt>
                                            <dd>{{ $sale->due_date ? \Carbon\Carbon::parse($sale->due_date)->format('d/m/Y') : '-' }}
                                            </dd>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Kasir</dt>
                                    <dd>{{ $sale->user->name }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Payment Details</h3>
                            <dl class="mt-4 space-y-2">
                                <div>
                                    <dt class="font-medium text-gray-500">Total Belanja</dt>
                                    <dd>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Potongan</dt>
                                    <dd>Rp {{ number_format($sale->discount, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Total Setelah Potongan</dt>
                                    <dd>Rp {{ number_format($sale->total_amount - $sale->discount, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Uang Muka</dt>
                                    <dd>Rp {{ number_format($sale->down_payment, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Sudah Dibayar</dt>
                                    <dd>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Sisa Hutang</dt>
                                    <dd>Rp {{ number_format($sale->remaining_amount, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Kembalian</dt>
                                    <dd>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Sale Items</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            No</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Product</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Price</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Quantity</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($sale->saleDetails as $index => $detail)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $detail->product->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $detail->product->code }}</div>
                                            </td>
                                            <td class="px-6 py-4">Rp
                                                {{ number_format($detail->selling_price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">{{ $detail->quantity }}</td>
                                            <td class="px-6 py-4">Rp
                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-medium">Total:</td>
                                        <td class="px-6 py-4 font-bold">Rp
                                            {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-medium">Paid Amount:</td>
                                        <td class="px-6 py-4">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-medium">Change:</td>
                                        <td class="px-6 py-4">Rp {{ number_format($sale->change_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if ($sale->notes)
                        <div class="mt-6 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900">Notes</h3>
                            <p class="mt-2 text-gray-600">{{ $sale->notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-6 flex justify-end space-x-3 print:hidden">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            Back
                        </x-secondary-button>
                        @unless ($sale->trashed())
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-danger-button
                                    onclick="return confirm('Are you sure you want to void this sale? This will return the products to inventory.')">
                                    Void Sale
                                </x-danger-button>
                            </form>
                        @endunless
                    </div>

                    <!-- Thank You Message (Visible when printing) -->
                    <div class="hidden print:block mt-8 text-center">
                        <p class="text-sm text-gray-600">Thank you for your purchase!</p>
                        <p class="text-xs text-gray-500 mt-2">Please keep this invoice for your records.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-container,
            .print-container * {
                visibility: visible;
            }

            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print:hidden {
                display: block !important;
            }

            .no-print {
                display: none !important;
            }

            @page {
                margin: 2cm;
            }
        }
    </style>
</x-app-layout>
