@can('menu_strcture')
    <li>
        <a data-toggle="collapse" href="#baseInformationMenu">
            <i class="material-icons">image</i>
            <p>
                مدیریت ساختار سازمانی
                <b class="caret"></b>
            </p>
        </a>

        <div class="collapse" id="baseInformationMenu">
            <ul class="nav">
                {{-- Base mnue --}}
                @can('menu_base')
                    <li>
                        <a href="{{ route('base.structure') }}">
                            <span class="sidebar-normal">
                                 اطلاعات پایه
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Base Eduaction  -->
                @isUniversity
                    @can('menu_educational')
                        <li>
                            <a href="{{ route('base.education') }}">
                                <span class="sidebar-normal">
                                     اطلاعات پایه تحصیلی
                                </span>
                            </a>
                        </li>
                    @endcan
                @endisUniversity
                <!-- /Base Eduaction  -->

                <!-- Base Dormitory  -->
                @isUniversity
                    @can('menu_dormitory')
                        <li>
                            <a href="{{ route('base.dormitory') }}">
                                <span class="sidebar-normal">
                                     اطلاعات پایه خوابگاه
                                </span>
                            </a>
                        </li>
                    @endcan
                @endisUniversity
                <!-- /Base Dormitory  -->

                <!-- Base Parking  -->

                    <li>
                        <a href= "{{ route('base.parking') }}">
                            <span class="sidebar-normal">
                                 اطلاعات پایه پارکینگ
                            </span>
                        </a>
                    </li>

                <!-- /Base Parking  -->
            </ul>
        </div>
    </li>
@endcan
