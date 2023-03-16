@extends('layouts.layout')
@section('main')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Dashboard</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Inicio</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-3 col-md-6">
            <div class="card top_counter">
                <div class="body">
                    <div class="icon text-info"><i class="fa fa-user"></i> </div>
                    <div class="content">
                        <div class="text">Total Student</div>
                        <h5 class="number">530</h5>
                    </div>
                    <hr>
                    <div class="icon text-warning"><i class="fa fa-user-circle"></i> </div>
                    <div class="content">
                        <div class="text">Total Teacher</div>
                        <h5 class="number">14</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card top_counter">
                <div class="body">
                    <div class="icon text-warning"><i class="fa fa-tags"></i> </div>
                    <div class="content">
                        <div class="text">Department</div>
                        <h5 class="number">7</h5>
                    </div>
                    <hr>
                    <div class="icon"><i class="fa fa-graduation-cap"></i> </div>
                    <div class="content">
                        <div class="text">Courses</div>
                        <h5 class="number">35</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card top_counter">
                <div class="body">
                    <div class="icon text-danger"><i class="fa fa-credit-card"></i> </div>
                    <div class="content">
                        <div class="text">Expense</div>
                        <h5 class="number">$3205</h5>
                    </div>
                    <hr>
                    <div class="icon text-success"><i class="fa fa-university"></i> </div>
                    <div class="content">
                        <div class="text">Income</div>
                        <h5 class="number">$35,325</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card top_counter">
                <div class="body">
                    <div class="icon"><i class="fa fa-map-pin"></i> </div>
                    <div class="content">
                        <div class="text">Our Center</div>
                        <h5 class="number">28</h5>
                    </div>
                    <hr>
                    <div class="icon text-success"><i class="fa fa-smile-o"></i> </div>
                    <div class="content">
                        <div class="text">Happy Clients</div>
                        <h5 class="number">528</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>University Survey</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another Action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="row text-center">
                        <div class="col-sm-3 col-6">
                            <h4 class="margin-0">$231</h4>
                            <p class="text-muted margin-0"> Today's</p>
                        </div>
                        <div class="col-sm-3 col-6">
                            <h4 class="margin-0">$1,254</h4>
                            <p class="text-muted margin-0">This Week's</p>
                        </div>
                        <div class="col-sm-3 col-6">
                            <h4 class="margin-0">$3,298</h4>
                            <p class="text-muted margin-0">This Month's</p>
                        </div>
                        <div class="col-sm-3 col-6">
                            <h4 class="margin-0">$9,208</h4>
                            <p class="text-muted margin-0">This Year's</p>
                        </div>
                    </div>
                    <div id="m_bar_chart" class="graph m-t-20"></div>                            
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2>Income Analysis<small>8% High then last month</small></h2>
                </div>
                <div class="body">                            
                    <div class="sparkline-pie text-center">6,4,8</div>
                    <div class="stats-report">
                        <div class="stat-item">
                        <h5>Science</h5>
                        <b class="col-black">84.60%</b></div>
                        <div class="stat-item">
                        <h5>Commerce</h5>
                        <b class="col-black">15.40%</b></div>
                        <div class="stat-item">
                        <h5>Atrs</h5>
                        <b class="col-black">5.10%</b></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2>Science Department<small >All Earnings are in million $</small></h2>
                    
                </div>
                <div class="body">
                    <div class="sparkline" data-type="line" data-spot-Radius="2" data-highlight-Spot-Color="#445771" data-highlight-Line-Color="#222"
                        data-min-Spot-Color="#445771" data-max-Spot-Color="#445771" data-spot-Color="#445771"
                        data-offset="90" data-width="100%" data-height="100px" data-line-Width="1" data-line-Color="#ffcd55"
                        data-fill-Color="#ffcd55"> 2,5,3,2,1,7,6,0,2</div>
                    <div class="stats-report">
                        <div class="stat-item">
                        <h5>Overall</h5>
                        <b class="col-indigo">7,000</b></div>
                        <div class="stat-item">
                        <h5>2016</h5>
                        <b class="col-indigo">2,000</b></div>
                        <div class="stat-item">
                        <h5>2017</h5>
                        <b class="col-indigo">5,000</b></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2>Commerce Department<small>All Earnings are in million $</small></h2>                            
                </div>
                <div class="body">                           
                    <div class="sparkline" data-type="bar" data-width="97%" data-height="100px" data-bar-Width="7" data-bar-Spacing="10" data-bar-Color="#02b5b2">2,8,3,4,6,2,3,8,7,6,5,2,1,8</div>
                    <div class="stats-report">
                        <div class="stat-item">
                        <h5>Overall</h5>
                        <b class="col-indigo">3,200</b></div>
                        <div class="stat-item">
                        <h5>2016</h5>
                        <b class="col-indigo">1,200</b></div>
                        <div class="stat-item">
                        <h5>2017</h5>
                        <b class="col-indigo">2,000</b></div>
                    </div>
                </div>
            </div>
        </div>                            
    </div>
</div>
{{-- @auth
    window.user = @json(auth()->user())
@endauth --}}
@endsection