@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-11">
                            <div><label>Tìm kiếm:<input type="search" class="form-control form-control-sm" placeholder="Nhập tìm kiếm" onkeyup="search()" id="partner_search"></label></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="table-scroll">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" id="partner_table">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">STT</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Tên</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Số điện thoại</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Email</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Tên nhà xe</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1">Nội dung yêu cầu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $partner)
                                    <tr>
                                        <td></td>
                                        <td>{{ $partner->name }}</td>
                                        <td>{{ $partner->phone }}</td>
                                        <td>{{ $partner->email }}</td>
                                        <td>{{ $partner->name_company }}</td>
                                        <td>{{ $partner->message }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::to('/js/admin/partner.js') }}"></script>
<style type="text/css">
    #table-scroll {
        max-height: 630px;
        overflow: auto;
    }

    #table-scroll th {
        background-color: #f4f6f9;
        position: sticky;
        top: 0;
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    table {
        counter-reset: rowNumber - 1;
    }

    table tr {
        counter-increment: rowNumber;
    }

    table tr td:first-child::before {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }
</style>
@endsection