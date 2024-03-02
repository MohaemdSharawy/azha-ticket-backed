<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="userId" content="<?php echo e(Auth::id() ?? ''); ?>">
    <title>Ticket System</title>

    <meta name="description"
        content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description"
        content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    
    <link rel="icon" type="image/png" href="<?php echo e(URL::asset('Logo/launcher_icon.png')); ?>" />

    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo e(URL::asset('admin/assets/media/favicons/favicon-192x192.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo e(URL::asset('admin/assets/media/favicons/apple-touch-icon-180x180.png')); ?>">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Fonts and OneUI framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="<?php echo e(URL::asset('admin/assets/css/oneui.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/assets/js/plugins/summernote/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/assets/js/plugins/simplemde/simplemde.min.css')); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('css/dropzone.min.css')); ?>">
    
    <script src="<?php echo e(URL::asset('js/dropzone.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/assets/js/plugins/select2/css/select2.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(URL::asset('css/bootstrap-select.css')); ?>">


    

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>
    <!-- Page Container -->
    <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-dark'                              Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Light themed Header
            'page-header-dark'                          Dark themed Header

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->

    <?php
        $user_module = checkPermission(1);
        $hotel_module = checkPermission(2);
        $log_module = checkPermission(3);
        $dep_module = checkPermission(4);
        // $survey_module = checkPermission(5);
        // $mail_setup_module = checkPermission(6);
        $service_permission = checkPermission(6);
        $facility_permission = checkPermission(7);
        
    ?>

    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <!-- Side Overlay-->
        <aside id="side-overlay">
            <!-- Side Header -->
            <div class="content-header border-bottom">
                <!-- User Avatar -->
                <a class="img-link mr-1" href="javascript:void(0)">
                    <img class="img-avatar img-avatar32"
                        src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar10.jpg')); ?>" alt="">
                </a>
                <!-- END User Avatar -->

                <!-- User Info -->
                <div class="ml-2">
                    <a class="text-dark font-w600 font-size-sm" href="javascript:void(0)"><?php echo e(Auth::user()->name); ?></a>
                </div>
                <!-- END User Info -->

                <!-- Close Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="ml-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout"
                    data-action="side_overlay_close">
                    <i class="fa fa-fw fa-times"></i>
                </a>
                <!-- END Close Side Overlay -->
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="content-side">
                <!-- Side Overlay Tabs -->
                <div class="block block-transparent pull-x pull-t">
                    <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#so-overview">
                                <i class="fa fa-fw fa-coffee text-gray mr-1"></i> Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#so-sales">
                                <i class="fa fa-fw fa-chart-line text-gray mr-1"></i> Sales
                            </a>
                        </li>
                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        <!-- Overview Tab -->
                        <div class="tab-pane pull-x fade fade-left show active" id="so-overview" role="tabpanel">
                            <!-- Activity -->
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Recent Activity</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <!-- Activity List -->
                                    <ul class="nav-items mb-0">
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="si si-wallet text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-size-sm font-w600">New sale ($15)</div>
                                                    <div class="text-success">Admin Template</div>
                                                    <small class="font-size-sm text-muted">3 min ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="si si-pencil text-info"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-size-sm font-w600">You edited the file</div>
                                                    <div class="text-info">
                                                        Documentation.doc
                                                    </div>
                                                    <small class="font-size-sm text-muted">15 min ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="si si-close text-danger"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-size-sm font-w600">Project deleted</div>
                                                    <div class="text-danger">Line Icon Set</div>
                                                    <small class="font-size-sm text-muted">4 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- END Activity List -->
                                </div>
                            </div>
                            <!-- END Activity -->

                            <!-- Online Friends -->
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Online Friends</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>
                                        <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <!-- Users Navigation -->
                                    <ul class="nav-items mb-0">
                                        <li>
                                            <a class="media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                                    <img class="img-avatar img-avatar48"
                                                        src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar7.jpg')); ?>"
                                                        alt="">
                                                    <span
                                                        class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Susan Day</div>
                                                    <div class="font-size-sm text-muted">Copywriter</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                                    <img class="img-avatar img-avatar48"
                                                        src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar12.jpg')); ?>"
                                                        alt="">
                                                    <span
                                                        class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Scott Young</div>
                                                    
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                                    <img class="img-avatar img-avatar48"
                                                        src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar6.jpg')); ?>"
                                                        alt="">
                                                    <span
                                                        class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Barbara Scott</div>
                                                    <div class="font-size-sm text-muted">Web Designer</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                                    <img class="img-avatar img-avatar48"
                                                        src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar5.jpg')); ?>"
                                                        alt="">
                                                    <span
                                                        class="overlay-item item item-tiny item-circle border border-2x border-white bg-warning"></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Lori Grant</div>
                                                    <div class="font-size-sm text-muted">Photographer</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                                    <img class="img-avatar img-avatar48"
                                                        src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar14.jpg')); ?>"
                                                        alt="">
                                                    <span
                                                        class="overlay-item item item-tiny item-circle border border-2x border-white bg-warning"></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Ralph Murray</div>
                                                    <div class="font-size-sm text-muted">Graphic Designer</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- END Users Navigation -->
                                </div>
                            </div>
                            <!-- END Online Friends -->

                            <!-- Quick Settings -->
                            <div class="block mb-0">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Quick Settings</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option"
                                            data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <!-- Quick Settings Form -->
                                    <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                                        <div class="form-group">
                                            <p class="font-size-sm font-w600 mb-2">
                                                Online Status
                                            </p>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="so-settings-check1" name="so-settings-check1" checked>
                                                <label class="custom-control-label" for="so-settings-check1">Show your
                                                    status to all</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p class="font-size-sm font-w600 mb-2">
                                                Auto Updates
                                            </p>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="so-settings-check2" name="so-settings-check2" checked>
                                                <label class="custom-control-label" for="so-settings-check2">Keep up
                                                    to date</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p class="font-size-sm font-w600 mb-1">
                                                Application Alerts
                                            </p>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="so-settings-check3" name="so-settings-check3" checked>
                                                <label class="custom-control-label" for="so-settings-check3">Email
                                                    Notifications</label>
                                            </div>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="so-settings-check4" name="so-settings-check4" checked>
                                                <label class="custom-control-label" for="so-settings-check4">SMS
                                                    Notifications</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p class="font-size-sm font-w600 mb-1">
                                                API
                                            </p>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="so-settings-check5" name="so-settings-check5" checked>
                                                <label class="custom-control-label" for="so-settings-check5">Enable
                                                    access</label>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Quick Settings Form -->
                                </div>
                            </div>
                            <!-- END Quick Settings -->
                        </div>
                        <!-- END Overview Tab -->

                        <!-- Sales Tab -->
                        <div class="tab-pane pull-x fade fade-right" id="so-sales" role="tabpanel">
                            <div class="block mb-0">
                                <!-- Stats -->
                                <div class="block-content">
                                    <div class="row items-push pull-t">
                                        <div class="col-6">
                                            <div class="font-size-sm font-w600 text-uppercase">Sales</div>
                                            <a class="font-size-lg" href="javascript:void(0)">22.030</a>
                                        </div>
                                        <div class="col-6">
                                            <div class="font-size-sm font-w600 text-uppercase">Balance</div>
                                            <a class="font-size-lg" href="javascript:void(0)">$4.589,00</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Stats -->

                                <!-- Today -->
                                <div class="block-content block-content-full block-content-sm bg-body-light">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="font-size-sm font-w600 text-uppercase">Today</span>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span class="ext-muted">$996</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <ul class="nav-items push">
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $249</div>
                                                    <small class="text-muted">3 min ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $129</div>
                                                    <small class="text-muted">50 min ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $119</div>
                                                    <small class="text-muted">2 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $499</div>
                                                    <small class="text-muted">3 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- END Today -->

                                <!-- Yesterday -->
                                <div class="block-content block-content-full block-content-sm bg-body-light">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="font-size-sm font-w600 text-uppercase">Yesterday</span>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span class="text-muted">$765</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <ul class="nav-items push">
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $249</div>
                                                    <small class="text-muted">26 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-danger"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Product Purchase - $50</div>
                                                    <small class="text-muted">28 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $119</div>
                                                    <small class="text-muted">29 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-danger"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">Paypal Withdrawal - $300</div>
                                                    <small class="text-muted">37 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $129</div>
                                                    <small class="text-muted">39 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $119</div>
                                                    <small class="text-muted">45 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark media py-2" href="javascript:void(0)">
                                                <div class="mr-3 ml-2">
                                                    <i class="fa fa-fw fa-circle text-success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">New sale! + $499</div>
                                                    <small class="text-muted">46 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- More -->
                                    <div class="text-center">
                                        <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                            <i class="fa fa-arrow-down mr-1"></i> Load More..
                                        </a>
                                    </div>
                                    <!-- END More -->
                                </div>
                                <!-- END Yesterday -->
                            </div>
                        </div>
                        <!-- END Sales Tab -->
                    </div>
                </div>
                <!-- END Side Overlay Tabs -->
            </div>
            <!-- END Side Content -->
        </aside>

        <nav id="sidebar" aria-label="Main Navigation">
            <!-- Side Header -->
            <div class="content-header bg-white-5">
                <!-- Logo -->
                <a class="font-w600 text-dual" href="index.html">
                    <span class="smini-visible">
                        <i class="fa fa-circle-notch text-primary"></i>
                    </span>
                    <span class="smini-hide font-size-h5 tracking-wider">
                        Ticket<span class="font-w400">SYSTEM</span>
                    </span>
                </a>
                <!-- END Logo -->

                <!-- Extra -->
                <div>
                    <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close"
                        href="javascript:void(0)">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                    <!-- END Close Sidebar -->
                </div>
                <!-- END Extra -->
            </div>
            <!-- END Side Header -->

            <!-- Sidebar Scrolling -->
            <div class="js-sidebar-scroll">
                <!-- Side Navigation -->
                <div class="content-side">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link active" href="<?php echo e(route('dashboard')); ?>">
                                <i class="nav-main-link-icon si si-speedometer"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                            </a>
                        </li>



                        <li class="nav-main-heading">User Interface</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-energy"></i>
                                <span class="nav-main-link-name">Main Menu</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="<?php echo e(route('ticket')); ?>">
                                        <span class="nav-main-link-name">GSC</span>
                                    </a>
                                </li>
                                <?php if($facility_permission): ?>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="<?php echo e(route('facility')); ?>">
                                            <span class="nav-main-link-name">Facilities</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($service_permission && Auth::user()->is_admin == '1'): ?>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="<?php echo e(route('services')); ?>">
                                            <span class="nav-main-link-name">Services</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="<?php echo e(route('task')); ?>">
                                        <span class="nav-main-link-name">Tasks</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-energy"></i>
                                <span class="nav-main-link-name">Reports</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="<?php echo e(route('report')); ?>">
                                        <span class="nav-main-link-name">General Report</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="<?php echo e(route('report.worker')); ?>">
                                        <span class="nav-main-link-name">Worker Reports</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="<?php echo e(route('report.department')); ?>">
                                        <span class="nav-main-link-name">Department Report</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="<?php echo e(route('report.top_ten')); ?>">
                                        <span class="nav-main-link-name">Top Ten Report</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php if($hotel_module || $user_module || $dep_module): ?>
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                    aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon si si-badge"></i>
                                    <span class="nav-main-link-name">Admin</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <?php if($hotel_module): ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="<?php echo e(route('hotels')); ?>">
                                                <span class="nav-main-link-name">Hotels</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($user_module): ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="<?php echo e(route('users')); ?>">
                                                <span class="nav-main-link-name">Users</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($dep_module): ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="<?php echo e(route('department')); ?>">
                                                <span class="nav-main-link-name">Department</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($log_module): ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="<?php echo e(route('log')); ?>">
                                                <span class="nav-main-link-name">Log</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
                <!-- END Side Navigation -->
            </div>
            <!-- END Sidebar Scrolling -->
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="d-flex align-items-center">
                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                    <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    <!-- END Toggle Sidebar -->

                    <!-- Toggle Mini Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                    <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block"
                        data-toggle="layout" data-action="sidebar_mini_toggle">
                        <i class="fa fa-fw fa-ellipsis-v"></i>
                    </button>
                    <!-- END Toggle Mini Sidebar -->

                    <!-- Apps Modal -->
                    <!-- Opens the Apps modal found at the bottom of the page, after footer’s markup -->
                    <button type="button" class="btn btn-sm btn-dual mr-2" data-toggle="modal"
                        data-target="#one-modal-apps">
                        <i class="fa fa-fw fa-cubes"></i>
                    </button>
                    <!-- END Apps Modal -->

                    <!-- Open Search Section (visible on smaller screens) -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-sm btn-dual d-md-none" data-toggle="layout"
                        data-action="header_search_on">
                        <i class="fa fa-fw fa-search"></i>
                    </button>
                    <!-- END Open Search Section -->

                    <!-- Search Form (visible on larger screens) -->
                    <form class="d-none d-md-inline-block" action="be_pages_generic_search.html" method="POST">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-alt" placeholder="Search.."
                                id="page-header-search-input2" name="page-header-search-input2">
                            <div class="input-group-append">
                                <span class="input-group-text bg-body border-0">
                                    <i class="fa fa-fw fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                    <!-- END Search Form -->
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="d-flex align-items-center">
                    <!-- User Dropdown -->
                    <div class="custom-control custom-switch mb-1">
                        <input type="checkbox" class="custom-control-input" id="example-switch-custom1"
                            name="can_login" value="1" <?php if(Auth::user()->notify == 1): ?> checked <?php endif; ?>
                            onchange=changeNotificationStatus()>
                        <label class="custom-control-label" for="example-switch-custom1">
                            Notification
                        </label>
                    </div>

                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn btn-sm btn-dual d-flex align-items-center"
                            id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="rounded-circle"
                                src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar10.jpg')); ?>" alt="Header Avatar"
                                style="width: 21px;">
                            <span class="d-none d-sm-inline-block ml-2"><?php echo e(Auth::user()->name); ?></span>
                            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ml-1 mt-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="p-3 text-center bg-primary-dark rounded-top">
                                <img class="img-avatar img-avatar48 img-avatar-thumb"
                                    src="<?php echo e(URL::asset('admin/assets/media/avatars/avatar10.jpg')); ?>" alt="">
                                <p class="mt-2 mb-0 text-white font-w500"><?php echo e(Auth::user()->name); ?></p>
                                
                            </div>
                            <div class="p-2">
                                


                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    data-toggle="modal" data-target="#passwordChange">
                                    <span class="font-size-sm font-w500">Change Password</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    href="<?php echo e(route('logout')); ?>">
                                    <span class="font-size-sm font-w500">Log Out</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- END User Dropdown -->

                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn btn-sm btn-dual" id="page-header-notifications-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="text-primary">•</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 border-0 font-size-sm"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 bg-primary-dark text-center rounded-top">
                                <h5 class="dropdown-header text-uppercase text-white">Notifications</h5>
                            </div>
                            <ul class="nav-items mb-0" id="notification-list">
                                <?php if(Auth::user()->unreadNotifications->count()): ?>
                                    <?php $__currentLoopData = Auth::user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a class="text-dark media py-2"
                                                <?php if($notification->type == 'App\Notifications\TicketNotification'): ?> onclick="ViewTicket('<?php echo e($notification->data['id']); ?>')"
                                                <?php elseif($notification->type == 'App\Notifications\TaskNotification'): ?>
                                                onclick="ViewTask('<?php echo e($notification->data['id']); ?>')" <?php endif; ?>>
                                                <div class="mr-2 ml-3">
                                                    <i class="fa fa-fw fa-check-circle text-success"></i>
                                                </div>
                                                <div class="media-body pr-2">
                                                    <div class="font-w600">
                                                        <?php echo e($notification->data['message']); ?>

                                                    </div>
                                                    <span class="font-w500 text-muted">
                                                        <?php echo e($notification->created_at->diffForHumans(Carbon\Carbon::now())); ?>

                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-arrow-down mr-1"></i> Load More..
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="page-header-search" class="overlay-header bg-white">
                <div class="content-header">
                    <form class="w-100" action="be_pages_generic_search.html" method="POST">

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <button type="button" class="btn btn-alt-danger" data-toggle="layout"
                                    data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control" placeholder="Search or hit ESC.."
                                id="page-header-search-input" name="page-header-search-input">
                        </div>
                    </form>
                </div>

            </div>
            <!-- END Header Search -->



            <!-- Header Loader -->
            <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
            <div id="page-header-loader" class="overlay-header bg-white">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->

        <?php echo $__env->yieldContent('content'); ?>
        <!-- END Main Container -->

        <!-- Footer -->
        <footer id="page-footer" class="bg-body-light">
            <div class="content py-3">
                <div class="row font-size-sm">
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
                        <a class="font-w600" href="https://1.envato.market/AVD6j" target="_blank">Sunrise</a>
                        &copy; <span data-toggle="year-copy"></span>
                    </div>
                </div>
            </div>
        </footer>


        <div class="modal fade" id="one-modal-apps" tabindex="-1" role="dialog" aria-labelledby="one-modal-apps"
            aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Apps</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal"
                                    aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row gutters-tiny">
                                <div class="col-6">
                                    <!-- CRM -->
                                    <a class="block block-rounded block-link-shadow bg-body"
                                        href="https://crm.sunrise-resorts.com/authentication/admin">
                                        <div class="block-content text-center">
                                            <i class="si si-speedometer fa-2x text-primary"></i>
                                            <p class="font-w600 font-size-sm mt-2 mb-3">
                                                CRM
                                            </p>
                                        </div>
                                    </a>
                                    <!-- END CRM -->
                                </div>
                                <div class="col-6">
                                    <!-- Products -->
                                    <a class="block block-rounded block-link-shadow bg-body"
                                        href="https://newsign.sunrise-resorts.com">
                                        <div class="block-content text-center">
                                            <i class="si si-rocket fa-2x text-primary"></i>
                                            <p class="font-w600 font-size-sm mt-2 mb-3">
                                                E-Signature
                                            </p>
                                        </div>
                                    </a>
                                    <!-- END Products -->
                                </div>
                                <div class="col-6">
                                    <!-- Sales -->
                                    <a class="block block-rounded block-link-shadow bg-body mb-0"
                                        href="https://hrsign.sunrise-resorts.com">
                                        <div class="block-content text-center">
                                            <i class="si si-plane fa-2x text-primary"></i>
                                            <p class="font-w600 font-size-sm mt-2 mb-3">
                                                HR
                                            </p>
                                        </div>
                                    </a>
                                    <!-- END Sales -->
                                </div>
                                <div class="col-6">
                                    <!-- Payments -->
                                    <a class="block block-rounded block-link-shadow bg-body mb-0"
                                        href="https://srp.sunrise-resorts.com">
                                        <div class="block-content text-center">
                                            <i class="si si-wallet fa-2x text-primary"></i>
                                            <p class="font-w600 font-size-sm mt-2 mb-3">
                                                SRP
                                            </p>
                                        </div>
                                    </a>
                                    <!-- END Payments -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Apps Modal -->
        <?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="modal fade confirmation" id="passwordChange" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php echo e(route('update.user.password')); ?>"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required
                                placeholder="Password">
                            <br>
                            <label>Password Confirm</label>
                            <input type="password" class="form-control" name="password_confirm" required
                                placeholder="Password">
                            <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    
    <script src="<?php echo e(URL::asset('admin/assets/js/moment/moment.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('admin/assets/js/oneui.core.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('admin/assets/js/oneui.app.min.js')); ?>"></script>

    <!-- Page JS Plugins -->
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/chart.js/Chart.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/ckeditor/ckeditor.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/summernote/summernote-bs4.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/simplemde/simplemde.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/bootstrap-select.js')); ?>"></script>




    <script>
        $('.boot-select').selectpicker({
            actionsBox: true,
            style: "",
            styleBase: "form-control"
        });

        jQuery(function() {
            One.helpers(['summernote', 'ckeditor', 'simplemde', 'select2', 'sparkline']);
        });
    </script>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <?php echo $__env->make('tasks.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('tickets.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo $__env->make('layouts.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <script>
        function changeNotificationStatus() {
            window.location = '/users/change_notification'
        }

        let UserId = document.getElementsByName('userId')[0]['content'];
        Echo.private('App.Models.User.' + UserId).notification((notification) => {
            $('#notification-list').prepend(`
                <a class="text-dark media py-2" href="javascript:void(0)">
                    <div class="mr-2 ml-3">
                        <i class="fa fa-fw fa-check-circle text-success"></i>
                    </div>
                    <div class="media-body pr-2">
                        <div class="font-w600">
                            ${notification.message}
                        </div>
                        <span class="font-w500 text-muted">
                            ${moment(notification.created_at).fromNow()}
                        </span>
                    </div>
                </a>
            `);

            $(document).ready(function($) {
                setTimeout(function() {
                    One.helpers('notify', {
                        type: 'success',
                        icon: 'fa fa-check mr-1',
                        message: notification.message
                    });
                }, 30);
            });
        })


        function send_notification() {

        }
    </script>

    <script>
        let link = window.location.pathname
        let ticket_id = link.substring(link.lastIndexOf('/') + 1);

        console.log(link);
        if (link == '/ticket/show-model/' + ticket_id) {
            ViewTicket(ticket_id)
        }
    </script>

</body>

</html>
<?php /**PATH /home/sunrise/public_html/tickets/resources/views/layouts/admin.blade.php ENDPATH**/ ?>