@extends('admin.layouts.layout')
@section('css')
    <style>
        .all_price {
            font-size: 18px;
        }
    </style>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="col-md-4">
                <h3 class="box-title">订单统计(日) <br><small>{{ $day_compute['start_at'] }} ~ {{ $day_compute['stop_at'] }}</small></h3>
                    <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @foreach($day_compute['data'] as $k => $v)
                            <li class="{{ $loop->first?'active':'' }}"><a href="#tab_day_{{ $loop->index }}" data-toggle="tab">{{ $k }}</a></li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <?php $_all_price = 0?>
                        @foreach($day_compute['data'] as $k => $v)
                            <div class="tab-pane {{ $loop->first?'active':'' }}" id="tab_day_{{ $loop->index }}">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>商品名称</th>
                                        <th>销量</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($v as $v1)
                                        <tr>
                                            <td scope="row">{{ $v1->name }}</td>
                                            <td>{{ (int)$v1->sum_number }}</td>
                                        </tr>
                                        <?php $_all_price += $v1->sum_price ?>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        @endforeach
                        <!-- /.tab-pane -->
                        <div>
                            日销售总额: <b class="all_price">{{ $_all_price }}</b>元
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-md-4">
            <h3 class="box-title">订单统计(周) <br><small>{{ $week_compute['start_at'] }} ~ {{ $week_compute['stop_at'] }}</small></h3>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($week_compute['data'] as $k => $v)
                        <li class="{{ $loop->first?'active':'' }}"><a href="#tab_week_{{ $loop->index }}" data-toggle="tab">{{ $k }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <?php $_all_price = 0?>
                    @foreach($week_compute['data'] as $k => $v)
                        <div class="tab-pane {{ $loop->first?'active':'' }}" id="tab_week_{{ $loop->index }}">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>商品名称</th>
                                    <th>销量</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($v as $v1)
                                    <tr>
                                        <th scope="row">{{ $v1->name }}</th>
                                        <td>{{ (int)$v1->sum_number }}</td>
                                    </tr>
                                    <?php $_all_price += $v1->sum_price ?>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                @endforeach
                <!-- /.tab-pane -->
                    <div>
                        周销售总额: <b class="all_price">{{ $_all_price }}</b>元
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h3 class="box-title">订单统计(月) <br><small>{{ $month_compute['start_at'] }} ~ {{ $month_compute['stop_at'] }}</small></h3>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($month_compute['data'] as $k => $v)
                        <li class="{{ $loop->first?'active':'' }}"><a href="#tab_month_{{ $loop->index }}" data-toggle="tab">{{ $k }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <?php $_all_price = 0?>
                    @foreach($month_compute['data'] as $k => $v)
                        <div class="tab-pane {{ $loop->first?'active':'' }}" id="tab_month_{{ $loop->index }}">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>商品名称</th>
                                    <th>销量</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($v as $v1)
                                    <tr>
                                        <th scope="row">{{ $v1->name }}</th>
                                        <td>{{ (int)$v1->sum_number }}</td>
                                    </tr>
                                    <?php $_all_price += $v1->sum_price ?>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                @endforeach
                <!-- /.tab-pane -->
                    <div>
                        月销售总额: <b class="all_price">{{ $_all_price }}</b>元
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@stop
@section('js')
    <script>
        $(".select2").select2();
    </script>
@stop