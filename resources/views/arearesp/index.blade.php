
@extends('master')

@section('css')
<!-- Custom styles for this page -->
<link rel="stylesheet" type="text/css" href="vendor/datatables/css/dataTables.bootstrap4.min.css"/>
<link href="vendor/datatables/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
@stop
@section('main')

<input type="hidden"  id="csrf" value="{{ csrf_token() }}">

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

                        <a class="btn btn-secondary" href="{{ route('arearesp.create')}}" role="button">Nuevo
                            <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#plus-circle"/>
                            </svg>
                        </a>
                    </div>
                    <div id="editArearesp" class="col-sm">
                        <a class="btn btn-disabled" href="#" role="button">Editar
                            <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#pencil-square"/>
                            </svg>
                        </a>
                    </div>
                    <div id ="deleteArearesp" class="col-sm">
                        <a class="btn btn-disabled" href="#" role="button">Borrar
                            <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#x-circle"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
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
<script type="text/javascript" src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/vendor/datatables/js/dataTables.select.min.js" type="text/javascript"></script>
<!-- Page level custom scripts -->

<script type='text/javascript'>
/*
 * Displays list of products using
 * a datatables jQuery plugin on table id="example"
 */
$(document).ready(function () {
    var editButton = $('#editArearesp');
    var deleButton = $('#deleteArearesp');
    var csrf = $('#csrf');
    var table = $('#arearespTable').DataTable({
        "processing": true,
        "serverSide": true,
        "select": {
            style: 'single'
        },
        "ajax": {
            "url": "{{ url('/arearesp_ajax') }}",
            "type": "GET",
            'headers': {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')
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
     table //here we change 
        .on( 'select', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();
            editButton.html( '<a class="btn btn-secondary" href="/arearesp/'+ rowData[0]['id'] + '/edit" role="button">Editar<svg class="bi" width="32" height="32" fill="currentColor"><use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#pencil-square"/></svg></a>' );
            deleButton.html( '<form method="POST" action="/arearesp/' + rowData[0]['id'] + '" accept-charset="UTF-8">' +
                        '<input name="_method" type="hidden" value="DELETE">' +
                        '<input name="_token" type="hidden" value="' + $('meta[name="csrf-token"]').attr('content') + '">' +
                        '<button class="btn btn-secondary " onclick="if(!confirm(&#039;Are you sure to delete this item?&#039;)){return false;};" type="submit" value="Delete">Borrar <svg class="bi" width="32" height="32" fill="currentColor"><use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#x-circle"/></svg></button>' +
                        '</form>');
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            editButton.html( '<a class="btn btn-disabled" href="#" role="button">Editar <svg class="bi" width="32" height="32" fill="currentColor"><use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#pencil-square"/></svg></a>' );
            deleButton.html( '<a class="btn btn-disabled" href="#" role="button">Borrar <svg class="bi" width="32" height="32" fill="currentColor"><use xlink:href="vendor/bootstrap/img/bootstrap-icons.svg#x-circle"/></svg></a>' );
        } );
});
</script>

@stop