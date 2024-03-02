<?php $__env->startSection('content'); ?>
    <style>
        .dropdown-toggle {
            width: 350px;
            max-width: 350px;
        }
    </style>
    <?php echo $__env->make('layouts.datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/assets/js/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(URL::asset('admin/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')); ?>">


    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.css')); ?>">


    <main id="main-container">

        <!-- Hero -->

        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="row">
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="hotels">Hotels</label>
                                <select class="boot-select form-control" id="hotels" name="hid" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Hotel" multiple onchange="fillter()">
                                    <?php $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($hotel->id); ?>"><?php echo e($hotel->hotel_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <label for="from_time">From Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="from_time" name="from_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>

                        <div class="col-lg-3 ">
                            <label for="to_time">To Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="to_time" name="to_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="statues">Status</label>
                                <select class="boot-select form-control" id="stat" style="width: 100%;" name="statues"
                                    data-live-search="true" data-placeholder="Select Status" multiple onchange="fillter()">
                                    <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">Type</label>
                                <select class="boot-select form-control" id="types" name="types" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Types" multiple onchange="fillter()">
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">priority</label>
                                <select class="boot-select form-control" id="priority" name="priority" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select priority" multiple
                                    onchange="fillter()">
                                    <?php $__currentLoopData = $priority; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($pro->id); ?>"><?php echo e($pro->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">Departments</label>
                                <select class="boot-select form-control" id="department" name="department"
                                    style="width: 100%;" data-live-search="true" data-placeholder="Select department"
                                    multiple onchange="fillter()">
                                    <?php $__currentLoopData = $Departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($dep->id); ?>"
                                            <?php if(in_array($dep->id, $user_department)): ?> <?php echo e('selected'); ?> <?php endif; ?>>
                                            <?php echo e($dep->dep_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">Creator Type</label>
                                <select class="boot-select form-control" id="creator" name="creator" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select creator" onchange="fillter()">
                                    <option> All </option>
                                    <option value="staff"> Staff </option>
                                    <option value="guest"> Guest From App </option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">

            <div class="block block-rounded">
                <div class="block-header">
                    <a href="<?php echo e(route('ticket.create')); ?>"><button class="btn btn-primary js-swal-info" data-toggle="modal"
                            data-target="#staticBackdrop">Create
                            New Ticket <i class="fa fa-edit"></i></button></a>
                </div>
                <div class="block-content">


                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter" id="ticket"
                            style="width:100%">
                            <thead class="bg-flat-light">
                                <tr>
                                    <th>ID</th>
                                    <th> Name</th>
                                    <th>Hotel Name</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th width="19%"> At</th>
                                    <th>EndTime</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="ticket-table-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->




        





    </main>



    <?php $__env->startPush('scripts'); ?>
        <?php echo $__env->make('layouts.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script src="<?php echo e(URL::asset('admin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin/assets/js/jquery-ui.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin/assets/js/plugins/ckeditor5-classic/build/ckeditor.js')); ?>"></script>

        <script>
            jQuery(function() {

                One.helpers(['flatpickr', 'select2', 'datepicker', 'ckeditor5']);
            });
        </script>



        <script>
            getData();
        </script>
    <?php $__env->stopPush(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sunrise/public_html/tickets/resources/views/tickets/index.blade.php ENDPATH**/ ?>