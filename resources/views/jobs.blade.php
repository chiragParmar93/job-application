<x-app-layout>
    <x-slot name="header">
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
            <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        </head>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jobs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-5">
                    <table class="table table-bordered application-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Confirmation</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.application-datatable').DataTable({
                processing: true
                , serverSide: true
                , ajax: "{{ route('jobs.list') }}"
                , columns: [{
                        data: 'DT_RowIndex'
                        , name: 'DT_RowIndex'
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                    }
                    , {
                        data: 'email'
                        , name: 'email'
                    }
                    , {
                        data: 'gender'
                        , name: 'gender'
                    }
                    , {
                        data: 'phone'
                        , name: 'phone'
                    }

                    , {
                        data: 'action'
                        , name: 'action'
                        , orderable: true
                        , searchable: true
                    }
                , ]
            });
        });
        $(document).on('click', '.delete', function() {
            job_id = $(this).attr('id');
            if (confirm("Are you sure want to delete data")) {
                $.ajax({
                    type: 'DELETE'
                    , url: "jobs/" + job_id
                    , data: {
                        "_token": "{{ csrf_token() }}"
                        , "id": job_id
                    }
                    , success: function(data) {
                        setTimeout(function() {
                            $('.application-datatable').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            };
        });

    </script>
</x-app-layout>
