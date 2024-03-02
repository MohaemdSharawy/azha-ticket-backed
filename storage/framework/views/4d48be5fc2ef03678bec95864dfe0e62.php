
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('layouts.datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="main-container">
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Facilities List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Facilities</a>
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
                            New Facility <i class="fa fa-edit"></i></button></a>
                </div>

                <div class="block-content block-content-full">
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination " id="ticket"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Hotel</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row->id); ?></td>
                                    <td><?php echo e($row->name); ?></td>
                                    <?php if($row->hid != 0): ?>
                                        <td><?php echo e($row->hotels->hotel_name); ?></td>
                                    <?php else: ?>
                                        <td> ----- </td>
                                    <?php endif; ?>
                                    <td><?php echo e($row->type->name); ?></td>
                                    <td>
                                        <button
                                            onclick="edit_facility(`<?php echo e($row->type_id); ?>` ,`<?php echo e($row->hid); ?>` , `<?php echo e($row->name); ?>` , `<?php echo e($row->id); ?>`)"
                                            class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button>
                                        <i id="dep_stats-<?php echo e($row->id); ?>">

                                            <?php if($row->disable == 0): ?>
                                                <a href="<?php echo e(route('facility.disable', $row->id)); ?>"<button
                                                    class="btn btn-success js-swal-info"><i
                                                        class="fa fa-check-circle"></i></button></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('facility.disable', $row->id)); ?>"><button
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Hotel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('facility.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                        <br>
                        <label>Type</label>
                        <select class="form-control form-control-alt" name="type_id" required>
                            <option>-----</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($type->id != 1): ?>
                                    <option value=" <?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br>
                        <label>Hotel</label>
                        <select class="form-control form-control-alt" name="hid" required>
                            <option>-----</option>
                            <?php $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=" <?php echo e($hotel->id); ?>"><?php echo e($hotel->hotel_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
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




    

    <div class="modal fade" id="edit_model" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Hotel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('facility.update')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" class="form-control" name="facility_id" required id="facility_id">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required id="name">
                        <br>
                        <label>Type</label>
                        <select class="form-control form-control-alt" name="type_id" required id="type_id">
                            <option>-----</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($type->id != 1): ?>
                                    <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br>
                        <label>Hotel</label>
                        <select class="form-control form-control-alt" name="hid" required id="hid">
                            <option>-----</option>
                            <?php $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($hotel->id); ?>"><?php echo e($hotel->hotel_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
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

    <?php $__env->startPush('scripts'); ?>
        <?php echo $__env->make('layouts.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script>
            function edit_facility(type_id, hotel, name, id) {
                $("#edit_model").modal("show")
                $('#hid option').removeAttr('selected').filter('[value=' + hotel + ']').attr('selected', true)
                $('#type_id option').removeAttr('selected').filter('[value=' + type_id + ']').attr('selected', true)
                $("#name").val(name)
                $('#facility_id').val(id)
            }
        </script>
    <?php $__env->stopPush(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sunrise/public_html/tickets/resources/views/facility/index.blade.php ENDPATH**/ ?>