@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="h3 mb-4">{{ __('manage_payments') }}</h1>
        
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered datatables-packages">
                        <thead>
                            <tr>
                                <th>{{ __('order_id') }}</th>
                                <th>{{ __('user') }}</th>
                                <th>{{ __('date') }}</th>
                                <th>{{ __('subject') }}</th>
                                <th>{{ __('amount') }}</th>
                                <th>{{ __('status') }}</th>
                                <th>{{ __('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment['payment_intent_id'] }}</td>
                                    <td>{{ $payment['user_name'] }}</td>
                                    <td>{{ $payment['date'] }}</td>
                                    <td>{{ $payment['subject'] }}</td>
                                    <td>{{ $payment['amount'] }} {{ $payment['currency'] }}</td>
                                    <td>{{ $payment['status'] }}</td>
                                    <td>
                                        <a href="{{ $payment['redirect_url'] }}" class="btn btn-primary btn-sm">{{ __('view') }}</a>
                                        <!-- Add PDF download if implemented -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('no_payments_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(function() {
        $('.datatables-packages').DataTable({
            ordering: true,
            paging: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
                paginate: {
                    previous: "{{ __('Previous') }}",
                    next: "{{ __('Next') }}"
                },
                info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                infoEmpty: "{{ __('Showing 0 to 0 of 0 entries') }}",
                lengthMenu: "{{ __('Show _MENU_ entries') }}"
            }
        });
    });
</script>
@endsection