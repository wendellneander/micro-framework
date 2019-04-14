<?php $__env->startSection('content'); ?>

    <div class="pt-5">

        <h1 class="pb-2">Categories</h1>

        <div class="row">
            <div class="col-8">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success" href="/category/new">New</a>
                </div>
            </div>
            <div class="col-4">
                <form class="form-inline" method="get">
                    <div class="form-group mx-sm-3 mb-2">
                        <input value="<?php echo e($search ?? ''); ?>" name="q" type="text" class="form-control" id="search" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </form>
            </div>
        </div>

        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($categories) > 0): ?>

                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($category->getKey()); ?></td>
                        <td><?php echo e($category->name); ?></td>
                        <td class="actions">
                            <a class="btn btn-success btn-xs" href="/category/edit/<?php echo e($category->getKey()); ?>">edit</a>
                            <button class="btn btn-danger btn-xs" onclick="setCategory(<?php echo e($category->getKey()); ?>)"
                               data-toggle="modal" data-target="#delete-modal">delete</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td>Nothing here</td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

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
                    <button type="button" class="btn btn-primary" onclick="deleteCategory()">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        let selectedCategoryId = null

        let setCategory = (id) => selectedCategoryId = id

        let deleteCategory = () => {
            if(!selectedCategoryId){
                return;
            }

            window.location.href = '/category/delete/' + selectedCategoryId
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template', ['title' => 'Categories'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\php\mirum-framework\views/category/index.blade.php ENDPATH**/ ?>