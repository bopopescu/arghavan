@can('menu_referral')
          <li>
                <a data-toggle="collapse" href="#referralMenu">
                    <i class="fa fa-users"></i>
                    <p>
                       مدیریت مراجعه کنندگان
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="referralMenu">
                    <ul class="nav">

                        @can('menu_referral_warranty')
                            <li>
                                <a href="{{ url('/warranties') }}">
                                    <span class="sidebar-normal">
                                        ثبت ضمانت نامه
                                    </span>
                                </a>
                            </li>
                        @endcan

                        @can('menu_referral_type')
                            <li>
                                <a href="{{ url('/referralTypes') }}">
                                    <span class="sidebar-normal">
                                        نوع مراجعه کننده
                                    </span>
                                </a>
                            </li>
                        @endcan

                        @can('menu_referral_referral')
                            <li>
                                <a href="{{ url('/referrals') }}">
                                    <span class="sidebar-normal">
                                        مراجعه کنندگان
                                    </span>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </div>
            </li>

        @endcan
