<x-app-layout>
    @section('title', 'Biométrie')
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <x-breadcrumb.wrapper title="Biométrie">
                    <x-breadcrumb.item title="Biométrie" type="current" />
                </x-breadcrumb.wrapper>

                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('biometrie.face') }}" class="text-decoration-none">
                                    <div class="card" style="border-radius: 15px; border: 2px solid #4099ff;">
                                        <div class="card-body text-center p-5">
                                            <i class="ti ti-scan" style="font-size: 5rem; color: #4099ff;"></i>
                                            <h3 class="mt-3">Capture de Visage</h3>
                                            <p class="text-muted">Capturer et enregistrer une photo du visage</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('biometrie.empreinte') }}" class="text-decoration-none">
                                    <div class="card" style="border-radius: 15px; border: 2px solid #2ed8b6;">
                                        <div class="card-body text-center p-5">
                                            <i class="ti ti-fingerprint" style="font-size: 5rem; color: #2ed8b6;"></i>
                                            <h3 class="mt-3">Capture d'Empreinte</h3>
                                            <p class="text-muted">Capturer et enregistrer une empreinte digitale</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::app-content -->
    @endsection
</x-app-layout>
