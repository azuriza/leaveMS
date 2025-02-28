

<?php $__env->startSection('title', 'Users'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid px-4">
    <h4 class="mt-4">User</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">User</li>
    </ol>
    <div class="row mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-dark">
                        Users
                        <a href="<?php echo e(url('admin/add/user')); ?>" class="btn btn-primary float-end">
                            <i class="bi bi-plus"></i> Add User
                        </a>
                    </h4>
                </div>
                <div class="card-body table-responsive">
                    <table id="mydataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($item->name); ?></td>
                                    <td><?php echo e($item->last_name); ?></td>
                                    <td><?php echo e($item->email); ?></td>
                                    <td><?php echo e($item->gender); ?></td>
                                    <td><?php echo e($item->phone); ?></td>
                                    <td><?php echo e($item->department->dpname); ?></td>
                                    <td><?php echo e($item->role_as == '1' ? 'Admin' : 'User'); ?></td>
                                    <td>
                                        <a href="<?php echo e(url('admin/user/' . $item->id . '/edit')); ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <!-- Delete button commented out due to relationship issues -->
                                        <!--
                                        <form action="<?php echo e(url('admin/delete/user/' . $item->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-danger btn-sm" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        -->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT\leave-management-system\resources\views/admin/user/index.blade.php ENDPATH**/ ?>