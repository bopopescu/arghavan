
        @can('menu_report')
            <li>
                <a data-toggle="collapse" href="#reportMenu">
                    <i class="material-icons">timeline</i>
                    <p>
                        مدیریت گزارشات
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="reportMenu">
                    <ul class="nav">

                        {{-- Report Traffic --}}
                        @can('menu_report_traffic')
                            <li>
                                <a href="{{ route('report_traffic') }}">
                                    <span class="sidebar-normal">
                                        گزارشات تردد
                                    </span>
                                </a>
                            </li>
                        @endcan
                        {{-- /Report Traffic --}}

                        <!--  Monitor  -->
                        @can('menu_monitor_chart')
                            <li>
                                <a href="{{ route('report_monitor_traffic') }}">
                                    <span class="sidebar-normal">
                                       مانیتورینگ تردد
                                    </span>
                                </a>
                            </li>
                        @endcan
                        <!-- /Monitor -->

                        {{-- Report User --}}
                        @can('menu_report_user')
                            <li>
                                <a href="{{ route('report_show_user') }}">
                                    {{-- <span class="sidebar-mini">
                                        TR
                                    </span> --}}
                                    <span class="sidebar-normal">
                                        گزارشات کاربران
                                    </span>
                                </a>
                            </li>
                        @endcan
                        {{-- /Report User --}}

                    </ul>
                </div>
            </li>
        @endcan
