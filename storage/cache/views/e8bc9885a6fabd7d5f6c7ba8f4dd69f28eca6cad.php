<?php $__env->startSection('content'); ?>

    <div class="pt-5">

        <h1 class="pb-2"><?php echo e(isset($store_name) ? $store_name.' ' : ''); ?>Products</h1>

        <div class="row">
            <div class="col-6">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-success" href="/product/new">New</a>
                    <button type="button" class="btn btn-secondary"
                            data-toggle="modal" data-target="#import-modal">Import</button>
                </div>
            </div>
            <div class="col-6">
                <form class="form-inline" method="get">
                    <div class="form-group mb-2">
                        <select class="form-control" name="category" id="category">
                            <option value="">Select a category</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e(isset($category_id) && $category_id == $category->getKey() ? 'selected' : ''); ?>

                                        value="<?php echo e($category->getKey()); ?>">
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input value="<?php echo e($search ?? ''); ?>" name="q" type="text" class="form-control" id="search" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Apply</button>
                </form>
            </div>
        </div>

        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Category</th>
                    <th>Store</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($stores) > 0): ?>

                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><strong><?php echo e($store->name); ?></strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php $__currentLoopData = $store->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td></td>
                                <td><?php echo e($product->name); ?></td>
                                <td>$ <?php echo e($product->price); ?></td>
                                <td><?php echo e($product->category->name); ?></td>
                                <td><?php echo e($product->store->name); ?></td>
                                <td class="actions">
                                    <a class="btn btn-success btn-xs" href="/product/edit/<?php echo e($product->getKey()); ?>">edit</a>
                                    <button class="btn btn-danger btn-xs" onclick="setProduct(<?php echo e($product->getKey()); ?>)"
                                       data-toggle="modal" data-target="#delete-modal">delete</button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td>Nothing here</td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    <button type="button" class="btn btn-primary" onclick="deleteProduct()">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/product/import" enctype="multipart/form-data" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Import Products</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                   name="file" type="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        let selectedProductId = null

        let setProduct = (id) => selectedProductId = id

        let deleteProduct = () => {
            if(!selectedProductId){
                return;
            }

            window.location.href = '/product/delete/' + selectedProductId
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template', ['title' => 'Products'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\php\mirum-framework\views/product/index.blade.php ENDPATH**/ ?>