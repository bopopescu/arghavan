  @can('menu_gate_setting')
                            <li>
                                <a data-toggle="collapse" href="#gateSettingMenu">
                                    <i class="material-icons">settings_applications</i>
                                    <p>
                                        تنظیمات تردد
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse" id="gateSettingMenu">
                                    <ul class="nav">
                                    {{-- Gate Group --}}
                                        @can('menu_gate_setting_group')
                                            <li>
                                                <a href="{{ url('/gategroups') }}">
                                                    <span class="sidebar-normal">
                                                        تخصیص گروه دسترسی
                                                    </span>
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- /Gate Group --}}

                                        {{-- Gate Setting --}}
                                        @can('menu_gate_setting_setting')
                                            <li>
                                                <a href="{{ url('/gateoptions') }}">
                                                    <span class="sidebar-normal">
                                                        تنظیمات ورود و خروج
                                                    </span>
                                                </a>
                                            </li>
                                        @endcan
                                        {{-- /Gate Setting --}}
                                    </ul>
                                </div>
                            </li>
                        @endcan
