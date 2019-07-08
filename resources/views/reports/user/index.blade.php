@extends('layouts.app')

@section('content')
<div class="row" id="app">
    <h3>
        <div class="panel-heading"> گزارش کاربران</div>
    </h3>
    <div class="row">
        <!-- Pie Chart Staff -->
        <div class="col-md-4">
            <div class="card card-chart">
                <div class="card-header card-header-rose">
                    <div  class="text-center color-white">
                        <i class="fa fa-refresh fa-spin fa-fw fa-16x"></i>
                    </div>
                    <canvas id="barChart" width="500" height="290"></canvas>
                </div>
                <div class="card-body row">
                    <i class="fa fa-refresh fa-2x pd-right-05em pd-left-05em cursor-pointer"></i>
                    <h4 class="card-title inline-block">اطلاعات کارمندی</h4>
                    <!-- <p class="card-category pd-right-05em">  {{App\Home::todayDashboard()}} </p> -->
                </div>
            </div>
        </div>
        <!-- /Pie Chart  Staff-->
        @isUniversity
            <!-- Pie Chart Student -->
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-rose">
                        <div  class="text-center color-white">
                            <i class="fa fa-refresh fa-spin fa-fw fa-16x"></i>
                        </div>
                        <canvas id="studentChart" width="500" height="290"></canvas>
                    </div>
                    <div class="card-body row">
                        <i class="fa fa-refresh fa-2x pd-right-05em pd-left-05em cursor-pointer"></i>
                        <h4 class="card-title inline-block">اطلاعات دانشجویی</h4>
                        <!-- <p class="card-category pd-right-05em">  {{App\Home::todayDashboard()}} </p> -->
                    </div>
                </div>
            </div>
            <!-- /Pie Chart Student -->

            <!-- Pie Chart Teacher -->
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-rose">
                        <div  class="text-center color-white">
                            <i class="fa fa-refresh fa-spin fa-fw fa-16x"></i>
                        </div>
                        <canvas id="teacherChart" width="500" height="290"></canvas>
                    </div>
                    <div class="card-body row">
                        <i class="fa fa-refresh fa-2x pd-right-05em pd-left-05em cursor-pointer"></i>
                        <h4 class="card-title inline-block">اطلاعات اساتید</h4>
                    </div>
                </div>
            </div>
            <!-- /Pie Chart Teacher -->
        @endisUniversity
    </div>

@endsection

@section('scripts')
<script>
    document.pageData.report = {
        count_staff_all_url: '{{ route('report.user.staff.count.all') }}',
        count_student_all_url: '{{ route('report.user.student.count.all') }}',
        count_teacher_all_url: '{{ route('report.user.teacher.count.all') }}',
    };
</script>
<script src="{{ mix('js/jsapi.js') }}"></script>
<script src="{{ mix('js/Chart.js') }}"></script>
<script src="{{ mix('js/pages/reports/user.js') }}"></script>
@endsection

