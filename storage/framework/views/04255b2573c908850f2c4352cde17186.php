<?php if(Session::has('permission')): ?>
    <div class="alert alert-danger"> <?php echo e(Session::get('permission')); ?></div>
<?php endif; ?>
<?php if(Session::has('success')): ?>
    <div class="alert alert-danger"> <?php echo e(Session::get('success')); ?></div>
<?php endif; ?>
<?php if(Session::has('success_notify')): ?>
    <script>
        $(document).ready(function($) {
            setTimeout(function() {
                One.helpers('notify', {
                    type: 'success',
                    icon: 'fa fa-check mr-1',
                    message: "<?php echo e(Session::get('success_notify')); ?>"
                });
            }, 10);
        });
    </script>
    
<?php endif; ?>
<?php if(Session::has('failed_notify')): ?>
    <script>
        $(document).ready(function($) {
            setTimeout(function() {
                One.helpers('notify', {
                    type: 'danger',
                    icon: 'fa fa-times mr-1',
                    message: "<?php echo e(Session::get('failed_notify')); ?>"
                });
            }, 10);
        });
    </script>
    
<?php endif; ?>
<?php /**PATH /home/sunrise/public_html/tickets/resources/views/layouts/alerts.blade.php ENDPATH**/ ?>