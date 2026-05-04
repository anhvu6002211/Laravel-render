@extends('layouts.app')

@section('title', 'Quản lý Hóa đơn & Thanh toán')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900">📄 Quản lý Hóa đơn & Thanh toán <span class="text-lg text-gray-500 font-normal">(Dành cho Cư dân)</span></h1>
</div>

<div class="card mb-8">
    <form action="{{ route('cursors.index') }}" method="GET" class="flex gap-4 items-center flex-wrap">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm theo Mã hóa đơn..." class="form-control">
        </div>
        <div class="w-48">
            <select name="status" class="form-control text-gray-700">
                <option value="">Trạng thái (Tất cả)</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Quá hạn</option>
            </select>
        </div>
        <div class="w-48">
            <input type="month" name="month_year" value="{{ request('month_year') }}" class="form-control text-gray-700">
        </div>
        <div class="w-48">
            <select name="category_id" class="form-control text-gray-700">
                <option value="">Loại dịch vụ (Tất cả)</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }} (Điện, Nước...)
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-secondary px-6">Lọc</button>
    </form>
</div>

<div class="card p-0 overflow-hidden divide-y divide-gray-100">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-4 font-semibold text-gray-700">Mã hóa đơn</th>
                <th class="p-4 font-semibold text-gray-700">Loại dịch vụ</th>
                <th class="p-4 font-semibold text-gray-700">Tổng tiền</th>
                <th class="p-4 font-semibold text-gray-700">Trạng thái</th>
                <th class="p-4 font-semibold text-gray-700 text-center">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($cursors as $cursor)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-medium text-gray-900">#{{ strtoupper(substr(md5($cursor->id), 0, 8)) }} <div class="text-xs text-gray-400 font-normal mt-1">{{ $cursor->name }}</div></td>
                    <td class="p-4 text-gray-600">{{ $cursor->category->name }}</td>
                    <td class="p-4 font-bold text-red-600">{{ number_format(rand(50000, 2000000), 0, ',', '.') }} VNĐ</td>
                    <td class="p-4">
                        @php $statusArr = ['Chưa thanh toán' => 'bg-yellow-100 text-yellow-800', 'Đã thanh toán' => 'bg-green-100 text-green-800', 'Quá hạn' => 'bg-red-100 text-red-800']; $randomStatus = array_rand($statusArr); @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusArr[$randomStatus] }}">
                            {{ $randomStatus }}
                        </span>
                    </td>
                    <td class="p-4 flex gap-2 justify-center">
                        @if($cursor->file_download)
                            <a href="{{ asset('storage/' . $cursor->file_download) }}" class="btn btn-secondary text-sm py-1.5 px-3" download>📥 PDF</a>
                        @endif
                        @if($randomStatus !== 'Đã thanh toán')
                            <a href="{{ route('cursors.show', $cursor) }}" class="btn btn-primary text-sm py-1.5 px-3">💳 Thanh toán</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($cursors->isEmpty())
        <div class="p-8 text-center text-gray-500">
            Không tìm thấy hóa đơn nào.
        </div>
    @endif
</div>

<div class="mt-8">
    {{ $cursors->links() }}
</div>
@endsection
