<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <style>
        

     .page-title {
         margin-bottom: 20px;
     }

     .green {
         color: #00A8B3;
     }

     .text-center {
         text-align: center;
     }

     .h3, h3 {
         font-size: 24px;
     }

     .table-bordered {
         border-left: none;
         border-right: none;
     }
     

     .table {
         width: 100%;
         max-width: 100%;
         margin-bottom: 20px;
     }

     table {
         background-color: transparent;
     }

     table {
         border-spacing: 0;
         border-collapse: collapse;
     }


     .personal-task.table-hover > tbody > tr:hover > td, .table-hover > tbody > tr:hover > th {
        background-color: #f7f8fc;
    }

    .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
        padding: 10px;
    }

    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #ddd;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    tr td:first-child, tr th:first-child {
        /* padding-left: 40px !important; */
    }

    table td[class*=col-], table th[class*=col-] {
        position: static;
        display: table-cell;
        float: none;
    }

    .col-lg-3 {
        width: 23.23%;
    }

    .col-lg-9 {
        width: 73.23%;
    }

    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9 {
        float: left;
    }

    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    th {
        text-align: left;
    }

    td, th {
        padding: 0;
    }

    </style>

</head>
<body>

<div class="app-container col-md-12">
    <h3 class="page-title text-center green">{{  $page_title  }}</h3>
        <table id="" class="table table-bordered table-hover table-striped vertical-table">
            <tr>
                <th class="col-lg-3">Organization Name</th>
                <td class="col-lg-3">{{ isset($company_name)?ucfirst($company_name):''}}</td>
            </tr>

            <tr>
                <th class="col-lg-3">User Name</th>
                <td class="col-lg-3">{{ isset($user_name)?ucfirst($user_name):''}}</td>
            </tr>

            <tr>
                <th class="col-lg-3">From Email</th>
                <td class="col-lg-3">{{ isset($from_email)?$from_email:''}}</td>
            </tr>

            <tr>
                <th class="col-lg-3">Letter No</th>
                <td class="col-lg-3">{{ isset($letter_no)?ucfirst($letter_no):''}}</td>
            </tr>

            <tr>
                <th class="col-lg-3">Subject</th>
                <td class="col-lg-3">{{ isset($subject)?ucfirst($subject):''}}</td>
            </tr>
        </table>
</div>

</body>
</html>