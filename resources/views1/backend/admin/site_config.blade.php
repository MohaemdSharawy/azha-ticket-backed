@extends('layouts.admin')
@section('content')
    <main id="main-container">

        <div class="content">
            <h2 class="content-heading">Animated <small>You can use the animation classes of your choice</small></h2>
            <div class="row">
                <div class="col-sm-4">
                    <div class="block block-rounded invisible" data-toggle="appear" data-class="animated bounceIn">
                        <div class="block-content block-content-full">
                            <div class="py-5 text-center">
                                <div class="item item-2x item-rounded bg-warning text-white mx-auto">
                                    <i class="si fa-2x si-user"></i>
                                </div>
                                <div class="font-size-h4 font-w600 pt-3 mb-0">Users</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="block block-rounded invisible" data-toggle="appear" data-class="animated flipInX">
                        <div class="block-content block-content-full">
                            <div class="py-5 text-center">
                                <div class="item item-2x item-rounded bg-danger text-white mx-auto">
                                    <i class="si fa-2x si-settings"></i>
                                </div>
                                <div class="font-size-h4 font-w600 pt-3 mb-0">Settings</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="block block-rounded invisible" data-toggle="appear" data-class="animated flash">
                        <div class="block-content block-content-full">
                            <div class="py-5 text-center">
                                <div class="item item-2x item-rounded bg-info text-white mx-auto">
                                    <i class="si fa-2x fa-2x si-rocket"></i>
                                </div>
                                <div class="font-size-h4 font-w600 pt-3 mb-0">Startup</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
