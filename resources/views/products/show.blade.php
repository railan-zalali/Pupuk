<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Produk') }}
        </h2>
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

            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Produk</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="font-medium text-gray-500">Kode</dt>
                                    <dd class="mt-1">{{ $product->code }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Nama</dt>
                                    <dd class="mt-1">{{ $product->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Kategori</dt>
                                    <dd class="mt-1">{{ $product->category->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Deskripsi</dt>
                                    <dd class="mt-1">{{ $product->description ?? 'Tidak ada deskripsi' }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Stok & Harga</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="font-medium text-gray-500">Stok Saat Ini</dt>
                                    <dd class="mt-1 @if ($product->stock <= $product->min_stock) text-red-600 font-bold @endif">
                                        {{ $product->stock }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Stok Minimum</dt>
                                    <dd class="mt-1">{{ $product->min_stock }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Harga Beli</dt>
                                    <dd class="mt-1">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Harga Jual</dt>
                                    <dd class="mt-1">Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Form Penyesuaian Stok -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Penyesuaian Stok</h3>
                        <form action="{{ route('products.updateStock', $product) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <x-input-label for="adjustment_type" value="Jenis Penyesuaian" />
                                    <select id="adjustment_type" name="adjustment_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="add">Tambah Stok</option>
                                        <option value="subtract">Kurangi Stok</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="quantity" value="Jumlah" />
                                    <x-text-input id="quantity" name="quantity" type="number"
                                        class="mt-1 block w-full" min="1" required />
                                </div>

                                <div>
                                    <x-input-label for="notes" value="Catatan" />
                                    <x-text-input id="notes" name="notes" type="text" class="mt-1 block w-full"
                                        placeholder="Catatan opsional" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-primary-button>
                                    Sesuaikan Stok
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Riwayat Pergerakan Stok -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Pergerakan Stok</h3>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Jenis</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Jumlah</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Sebelum</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Sesudah</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Referensi</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($product->stockMovements as $movement)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $movement->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                                    {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($movement->type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">{{ $movement->quantity }}</td>
                                            <td class="px-6 py-4">{{ $movement->before_stock }}</td>
                                            <td class="px-6 py-4">{{ $movement->after_stock }}</td>
                                            <td class="px-6 py-4">{{ ucfirst($movement->reference_type) }}</td>
                                            <td class="px-6 py-4">{{ $movement->notes ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada pergerakan stok ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <x-secondary-button onclick="window.history.back()">
                            Kembali
                        </x-secondary-button>
                        <a href="{{ route('products.edit', $product) }}"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Edit Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
