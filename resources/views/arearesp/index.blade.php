
@extends('master')

@section('css')
<!-- Custom styles for this page -->
<link rel="stylesheet" type="text/css" href="vendor/datatables/css/dataTables.bootstrap4.min.css"/>
<link href="vendor/datatables/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
@stop
@section('main')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm">
                        <h6 class="m-0 font-weight-bold text-primary">Areas de Responsabilidad</h6>
                    </div>  
                    <div class="col-sm">
                        <button type="button" class="btn btn-secondary">Nuevo
                            <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#plus-circle"/>
                            </svg>
                        </button>
                    </div>
                    <div class="col-sm">
                        <button type="button" class="btn btn-secondary">Editar
                            <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#pencil-square"/>
                            </svg>
                        </button>
                    </div>
                    <div class="col-sm">
                        <button type="button" class="btn btn-secondary">Eliminar
                            <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#x-circle"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="arearespTable" width="100%" cellspacing="0">
                    <thead>
                        <tr >
                            <th></th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Descripción</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@stop

@section('scripts')

<!-- Page level plugins -->
<script type="text/javascript" src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables/js/dataTables.select.min.js" type="text/javascript"></script>
<!-- Page level custom scripts -->

<script type='text/javascript'>
    /*
     * Displays list of products using
     * a datatables jQuery plugin on table id="example"
     */
    $(document).ready(function () {
        $('#arearespTable').DataTable({
            "processing": true,
            "serverSide": true,
            "select"    : true,
            "ajax": {
                "url": "{{ url('/arearesp_ajax') }}",
                "type": "GET",
                'headers': {'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "columns": [//tells where (from data) the columns are to be placed
                {"data": "id"},
                {"data": "description"}
            ]
        });
    });
</script>

@stop