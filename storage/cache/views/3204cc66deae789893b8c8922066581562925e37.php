<?php $__env->startSection('content'); ?>
    <div class="pt-5">

        <h1 class="pb-2"><?php echo e(isset($store) && $store ? 'Edit' : 'New'); ?> Store</h1>

        <form method="post" action="<?php echo e(isset($store) && $store ? '/update/' . $store->getKey() : '/save'); ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input required type="text" class="form-control"
                       id="name" name="name" value="<?php echo e(isset($store) && $store ? $store->name : ''); ?>">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input required type="text" class="form-control"
                       id="address" name="address" value="<?php echo e(isset($store) && $store ? $store->address : ''); ?>">
            </div>

            <button type="submit" class="btn btn-primary mb-2">Save</button>

            <?php if(isset($store) && $store): ?>
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#delete-modal">Delete</button>
            <?php endif; ?>

        </form>

    </div>

    <?php if(isset($store) && $store): ?>
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Delete Item</h4>
                    </div>
                    <div class="modal-body">
                        Do you really want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-primary" href="/delete/<?php echo e($store->getKey()); ?>">Yes</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\php\mirum-framework\views/store/form.blade.php ENDPATH**/ ?>