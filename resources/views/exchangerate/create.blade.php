@extends('master')

@section('main')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="container-fluid">
                <div class="col-sm">
                    <h6 class="m-0 font-weight-bold text-primary">Nueva Tasa</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                {{ Form::open(array('route'=>'exchangerates.store')) }}
                @include('exchangerate.form')
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @stop

    @section('scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
            $(function () {
                $("#rate_date").datepicker({ dateFormat: 'yy-mm-dd' });
            });
    </script>
    @stop