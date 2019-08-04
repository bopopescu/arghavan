
        @can('menu_request')
            <li class="active">
                <a data-toggle="collapse" href="#requestMenu">
                    <i class="fa fa-comments"></i>
                    <p>
                        مدیریت درخواست ها
                        <b class="caret"></b>
                    </p>
                </a>
                @isRoot
                    <div class="collapse" id="requestMenu">
                        <ul class="nav">
                            <!-- Comment Send Vaction -->
                            @can('menu_requestـvacation')
                                <li>
                                    <a href="{{ url('/vacationRequests') }}">
                                        <span class="sidebar-normal">
                                            ارسال درخواست مرخصی
                                        </span>
                                    </a>
                                </li>
                            @endcan
                            <!-- Comment Send Vacation -->

                            <!-- Comment Check Vacation -->
                            @can('menu_requestـcheck_vacation')
                                <li>
                                    <a href="{{ route('vacation_managment') }}">
                                        <span class="sidebar-normal">
                                            بررسی درخواست مرخصی
                                        </span>
                                    </a>
                                </li>
                            @endcan
                            <!-- /Comment Check Vacaion-->
                        </ul>
                    </div>
                @endisRoot
            </li>
        @endcan
