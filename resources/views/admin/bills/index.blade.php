@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
     
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('bill_number') }}</th>
                                <th>{{ __('user') }}</th>
                                <th>{{ __('date') }}</th>
                                <th>{{ __('subject') }}</th>
                                <th>{{ __('amount') }}</th>
                                <th>{{ __('status') }}</th>
                                <th>{{ __('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bills as $bill)
                                <tr>
                                    <td>{{ $bill['id'] }}</td>
                                    <td>{{ $bill['user_name'] }}</td>
                                    <td>{{ $bill['date'] }}</td>
                                    <td>{{ $bill['subject'] }}</td>
                                    <td>{{ $bill['amount'] }} {{ $bill['currency'] }}</td>
                                    <td>{{ $bill['status'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.bills.show', $bill['id']) }}" class="btn btn-primary btn-sm">{{ __('view') }}</a>
                                        <a href="{{ route('admin.bills.pdf', $bill['id']) }}" class="btn btn-success btn-sm">{{ __('download_pdf') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('no_bills_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Initialize DataTable
        var dataTable = $('.datatables-packages').DataTable({
            ordering: true,
            paging: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
            }
        });
    });
</script>
@endsection