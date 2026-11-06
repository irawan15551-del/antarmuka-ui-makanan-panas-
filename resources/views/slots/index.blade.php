@extends('layouts.app')
@section('title', 'Slot Mapping')
@section('breadcrumb', 'Slot Mapping')
@section('content')
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
	<div>
		<h1 class="text-2xl font-bold">Slot Mapping</h1>
		<p class="mt-1 text-sm text-slate-500">Atur produk untuk setiap slot mesin.</p>
	</div>
	<button type="submit" form="slot-mapping-form" class="rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white">
		Simpan Mapping
	</button>
</div>

@if (session('success'))
	<div role="status" class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
		{{ session('success') }}
	</div>
@endif

@error('slots')
	<div role="alert" class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
		{{ $message }}
	</div>
@enderror

@if ($products->isEmpty())
	<div class="mb-4 rounded-lg border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-900">
		Belum ada produk aktif untuk dipetakan.
		<a href="{{ route('products.create') }}" class="font-semibold underline">Tambah produk</a>
		terlebih dahulu.
	</div>
@endif

<form id="slot-mapping-form" method="POST" action="{{ route('slots.update') }}" class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-card">
	@csrf
	@method('PUT')
	<div class="overflow-x-auto">
		<table class="w-full min-w-[640px] text-sm">
			<thead class="bg-slate-50 text-slate-700">
				<tr>
					<th scope="col" class="p-4 text-left font-semibold">Slot</th>
					<th scope="col" class="p-4 text-left font-semibold">Produk</th>
					<th scope="col" class="p-4 text-left font-semibold">Status</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-slate-200">
				@foreach ($slots as $slot)
					@php($assignedProduct = $productsBySlot->get($slot))
					<tr>
						<th scope="row" class="p-4 text-left font-semibold text-slate-800">{{ $slot }}</th>
						<td class="p-3">
							<label class="sr-only" for="slot-{{ $slot }}">Produk untuk slot {{ $slot }}</label>
							<select id="slot-{{ $slot }}" name="slots[{{ $slot }}]" class="h-10 w-full min-w-56 rounded-md border border-slate-300 bg-white px-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
								<option value="">Kosong</option>
								@foreach ($products as $product)
									<option value="{{ $product->id }}" @selected((string) old('slots.'.$slot, $assignedProduct?->id) === (string) $product->id)>
										{{ $product->name }}
									</option>
								@endforeach
							</select>
							@error('slots.'.$slot)
								<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
							@enderror
						</td>
						<td class="p-4">
							<span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $assignedProduct ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
								{{ $assignedProduct ? 'Terisi' : 'Kosong' }}
							</span>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>
@endsection
