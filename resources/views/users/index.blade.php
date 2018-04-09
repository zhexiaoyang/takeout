@extends('layouts.app')

@section('title', '用户列表')


@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-reset.css') }}">
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Dynamic Table
                </header>
                <table class="table table-striped border-top" id="sample_1">
                    <thead>
                    <tr>
                        <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                        <th>Username</th>
                        <th class="hidden-phone">Email</th>
                        <th class="hidden-phone">Points</th>
                        <th class="hidden-phone">Joined</th>
                        <th class="hidden-phone"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>Jhone doe</td>
                        <td class="hidden-phone"><a href="mailto:jhone-doe@gmail.com">jhone-doe@gmail.com</a></td>
                        <td class="hidden-phone">10</td>
                        <td class="center hidden-phone">02.03.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>gada</td>
                        <td class="hidden-phone"><a href="mailto:gada-lal@gmail.com">gada-lal@gmail.com</a></td>
                        <td class="hidden-phone">34</td>
                        <td class="center hidden-phone">08.03.2013</td>
                        <td class="hidden-phone"><span class="label label-warning">Suspended</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>soa bal</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@yahoo.com">soa bal@yahoo.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">1.12.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>ram sag</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">soa bal@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">7.2.2013</td>
                        <td class="hidden-phone"><span class="label label-info">Blocked</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>durlab</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">test@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">03.07.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>durlab</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>sumon</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>bombi</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>ABC ho</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>test</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>soa bal</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">soa bal@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">03.07.2013</td>
                        <td class="hidden-phone"><span class="label label-info">Blocked</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>test</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">test@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">03.07.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>goop</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>sumon</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">01.07.2013</td>
                        <td class="hidden-phone"><span class="label label-info">Blocked</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>woeri</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">09.10.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>soa bal</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">soa bal@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">9.12.2013</td>
                        <td class="hidden-phone"><span class="label label-info">Blocked</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>woeri</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">test@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">14.12.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>uirer</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">13.11.2013</td>
                        <td class="hidden-phone"><span class="label label-warning">Suspended</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>samsu</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">17.11.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>dipsdf</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">05.04.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>soa bal</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">soa bal@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">03.07.2013</td>
                        <td class="hidden-phone"><span class="label label-info">Blocked</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>hilor</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">test@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">03.07.2013</td>
                        <td class="hidden-phone"><span class="label label-danger">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>test</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">19.12.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>botu</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">17.12.2013</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" value="1" /></td>
                        <td>sumon</td>
                        <td class="hidden-phone"><a href="mailto:soa bal@gmail.com">lorem-ip@gmail.com</a></td>
                        <td class="hidden-phone">33</td>
                        <td class="center hidden-phone">15.11.2011</td>
                        <td class="hidden-phone"><span class="label label-success">Approved</span></td>
                    </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript"  src="{{ asset('js/data-tables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/data-tables/DT_bootstrap.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/dynamic-table.js') }}"></script>
@stop