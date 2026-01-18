<x-app-layout>
    @section('title', 'MyAfia Tableau de bord')
    @section('css')
        <style>
            .order-card {
                /* color: #fff; */
            }

            .bg-c-blue {
                background: linear-gradient(45deg, #4099ff, #73b4ff);
            }

            .bg-c-green {
                background: linear-gradient(45deg, #2ed8b6, #59e0c5);
            }

            .bg-c-yellow {
                background: linear-gradient(45deg, #FFB64D, #ffcb80);
            }

            .bg-c-pink {
                background: linear-gradient(45deg, #FF5370, #ff869a);
            }


            .card {
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
                box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
                border: none;
                margin-bottom: 30px;
                -webkit-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out;
            }

            .card .card-block {
                padding: 25px;
            }

            .order-card i {
                font-size: 26px;
            }

            .f-left {
                float: left;
            }

            .f-right {
                float: right;
            }
        </style>
    @endsection
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Page du tableau de bord">
                    <x-breadcrumb.item title="Tableau de bord" type="current" />
                </x-breadcrumb.wrapper>


                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card order-card">
                                    <div class="card-block" style="padding-bottom: .5rem;">
                                        <h6 class="m-b-20">Fiche d'autorisation</h6>
                                        <h2 class="text-right d-flex justify-content-between align-items-center mt-4">
                                            <i class="ti ti-clipboard-list"
                                                style="font-size:2rem;"></i><span>{{ number_format($fiche_today) }}</span>
                                        </h2>
                                        <p class="m-b-0" style="font-weight: bold;">Aujourd'hui<span
                                                class="f-right"></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card order-card">
                                    <div class="card-block" style="padding-bottom: .5rem;">
                                        <h6 class="m-b-20">Fiche d'autorisation</h6>
                                        <h2 class="text-right d-flex justify-content-between align-items-center mt-4">
                                            <i class="ti ti-clipboard-list"
                                                style="font-size:2rem;"></i><span>{{ number_format($fiche_total) }}</span>
                                        </h2>
                                        <p class="m-b-0" style="font-weight: bold;">Total<span class="f-right"></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card order-card">
                                    <div class="card-block" style="padding-bottom: .5rem;">
                                        <h6 class="m-b-20">Fiche d'autorisation</h6>
                                        <h2 class="text-right d-flex justify-content-between align-items-center mt-4">
                                            <i class="ti ti-clipboard-list"
                                                style="font-size:2rem;"></i><span>{{ number_format($fiche_user_today) }}</span>
                                        </h2>
                                        <p class="m-b-0" style="font-weight: bold;">Aujourd'hui
                                            ({{ Auth::user()->name }})<span class="f-right"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card order-card">
                                    <div class="card-block" style="padding-bottom: .5rem;">
                                        <h6 class="m-b-20">Fiche d'autorisation</h6>
                                        <h2 class="text-right d-flex justify-content-between align-items-center mt-4">
                                            <i class="ti ti-clipboard-list"
                                                style="font-size:2rem;"></i><span>{{ number_format($fiche_user_total) }}</span>
                                        </h2>
                                        <p class="m-b-0" style="font-weight: bold;">Total
                                            ({{ Auth::user()->name }})<span class="f-right"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card order-card">
                                    <div class="card-block" style="padding-bottom: .5rem;">
                                        <h6 class="m-b-20">Total des utilisateurs</h6>
                                        <h2 class="text-right d-flex justify-content-between align-items-center mt-4">
                                            <i class="ti ti-users"
                                                style="font-size:2rem;"></i><span>{{ $usersCount }}</span>
                                        </h2>
                                        <p class="m-b-0" style="font-weight: bold;">Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- End::app-content -->


    @endsection

</x-app-layout>
