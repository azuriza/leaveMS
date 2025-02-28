

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <h4 class="mt-4">Profile</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Profile</li>
    </ol>
    <div class="row col-md-12 col-lg-12 col-xl-12">
        <!-- Profile Form Section -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="row col-md-12 col-lg-12 col-xl-12">
                            <!-- Name -->
                            <div class="form-group col-6 mb-3">
                                <label for="name">Name</label>
                                <input name="name" id="name" type="text" class="form-control"
                                    value="<?php echo e(old('name', $user->name)); ?>" />
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group col-6 mb-3">
                                <label for="last_name">Last Name</label>
                                <input name="last_name" id="last_name" type="text" class="form-control"
                                    value="<?php echo e(old('last_name', $user->last_name)); ?>" />
                                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Email -->
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input name="email" id="email" type="email" class="form-control"
                                    value="<?php echo e(old('email', $user->email)); ?>" />
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Profile Picture -->
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="profile_picture">Profile Picture</label>
                                <input name="profile_picture" id="profile_picture" type="file" class="form-control" />
                                <?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Picture Preview Section -->
        <div class="col-md-3 text-center">
            <div class="profile-picture-container">
                <?php if($user->profile_picture): ?>
                    <img src="<?php echo e(asset('profile_pictures/' . $user->profile_picture)); ?>" class="img-fluid profile-picture"
                        alt="Profile Picture">
                <?php else: ?>
                    <img src="<?php echo e(asset('views/assets/img/avatar.png')); ?>" class="img-fluid profile-picture"
                        alt="Default Avatar">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT\leave-management-system\resources\views/auth/profile/show.blade.php ENDPATH**/ ?>