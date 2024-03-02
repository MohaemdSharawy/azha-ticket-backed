<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('layouts.datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="main-container">
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Services List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Services</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">

            <div class="block block-rounded">
                <div class="block-header">
                    <a><button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#staticBackdrop">Create
                            New Services <i class="fa fa-edit"></i></button></a>
                </div>

                <div class="block-content block-content-full">
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination " id="ticket"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row->id); ?></td>
                                    <td><?php echo e($row->name); ?></td>
                                    <td><?php echo e($row->department->dep_name); ?></td>
                                    <td>
                                        <button
                                            onclick="edit_facility(`<?php echo e($row->dep_id); ?>` , `<?php echo e($row->type_id); ?>` ,`<?php echo e($row->name); ?>` ,`<?php echo e($row->id); ?>` , `<?php echo e($row->guest); ?>`)"
                                            class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button>
                                        <i id="dep_stats-<?php echo e($row->id); ?>">

                                            <?php if($row->disable == 0): ?>
                                                <a href="<?php echo e(route('services.disable', $row->id)); ?>"><button
                                                        class="btn btn-success js-swal-info"><i
                                                            class="fa fa-check-circle"></i></button></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('services.disable', $row->id)); ?>"><button
                                                        class="btn btn-danger js-swal-info"><i
                                                            class="fa fa-window-close"></i></button></a>
                                            <?php endif; ?>
                                        </i>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->
    </main>

    
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('services.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                        <br>
                        <label>Department</label>
                        <select class="form-control form-control-alt" name="dep_id" required>
                            <option>-----</option>
                            <?php $__currentLoopData = $deps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=" <?php echo e($dep->id); ?>"><?php echo e($dep->dep_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br>
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="guest-new" name="guest"
                                value="1">
                            <label class="custom-control-label" for="guest-new">
                                Guest Request (App)
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    

    <div class="modal fade" id="edit_model" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Hotel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('services.update')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="service_id" name="service_id">
                        <div class="row">
                            <div class="col-lg-4 ">
                                <label>Name(English)</label>
                                <input type="text" class="form-control" name="name" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>Arabic</label>
                                <input type="text" class="form-control" name="name_ar" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>Russion</label>
                                <input type="text" class="form-control" name="name_ru" required id="service_name">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 ">
                                <label>French</label>
                                <input type="text" class="form-control" name="name_fr" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>italian</label>
                                <input type="text" class="form-control" name="name_it" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>Germany</label>
                                <input type="text" class="form-control" name="name_de" required id="service_name">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 ">
                                <label>Dutch</label>
                                <input type="text" class="form-control" name="name_du" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>Romanian</label>
                                <input type="text" class="form-control" name="name_ro" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>Poland </label>
                                <input type="text" class="form-control" name="name_pl" required id="service_name">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 ">
                                <label>Czech</label>
                                <input type="text" class="form-control" name="name_cz" required id="service_name">
                                <br>
                            </div>
                            <div class="col-lg-4 ">
                                <label>Ukraine</label>
                                <input type="text" class="form-control" name="name_ua" required id="service_name">
                                <br>
                            </div>
                        </div>
                        <label>Department</label>
                        <select class="form-control form-control-alt" name="dep_id" id="dep_id" required>
                            <option>-----</option>
                            <?php $__currentLoopData = $deps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->dep_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br>
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="guest" name="guest"
                                value="1">
                            <label class="custom-control-label" for="guest">
                                Guest Request (App)
                            </label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <?php echo $__env->make('layouts.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script>
            function edit_facility(dep_id, type_id, name, id, guest) {
                $("#edit_model").modal("show");
                $('#dep_id option').removeAttr('selected').filter('[value=' + dep_id + ']').attr('selected', true)
                $('#service_name').val(name)
                $('#service_id').val(id)
                if (guest == 1) {
                    $('#guest').attr('checked', true)
                } else {
                    $('#guest').attr('checked', false)
                }
            }
        </script>
    <?php $__env->stopPush(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sunrise/public_html/tickets/resources/views/services/index.blade.php ENDPATH**/ ?>