
<?php $__env->startSection('content'); ?>

    <div class="container">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger my-4">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if(session()->has('message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('message')); ?>

            </div>
        <?php endif; ?>
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger mt-2">
                <?php echo e(session()->get('error')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-6">
                <div class="card p-3">
                    <h6 class="text-center">Total Orders</h6>
                    <strong class="text-center"><?php echo e($count_order); ?></strong>
                </div>
            </div>
            <div class="col-6">
                <div class="card p-3">
                    <h6 class="text-center">Total Spent</h6>
                    <strong class="text-center"><?php echo e(number_format($order_sum)); ?></strong>
                </div>
            </div>


        </div>

        <div class="row justify-content-end mb-4">
            <div class="col-xl-4 col-md-6">
                <form action="">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form--control"
                               value="<?php echo e(request()->search); ?>" placeholder="<?php echo app('translator')->get('Search by Trx'); ?>">
                        <button class="input-group-text bg--base border-0 text--white">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <div style="border-radius: 10px; margin-bottom: 20px; padding: 10px; background: #10113D;color: #ffffff; font-size: 11px">
            <div class="row">
                <div class="col">ID</div>
                <div class="col">Date</div>
                <div class="col">Amount(NGN)</div>
                <div class="col">Qty</div>
                <div class="col">View</div>
            </div>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $qty = @$order->orderItems->count();
                $perUnitPrice = @$order->orderItems->first()->price;
            ?>
            <div class="card">
                <div class="card-body " style="font-size: 11px;">
                    <div class="row">

                        <div class="col">
                            <?php echo e($order->id); ?>

                        </div>

                        <div class="col">
                            <?php echo e(diffForHumans($order->created_at)); ?>

                        </div>
                        <div class="col">
                            <?php echo e(showAmount($order->total_amount)); ?>

                        </div>
                        <div class="col">
                            <span><?php echo e(@$order->orderItems->count()); ?></span>
                        </div>
                        <div class="col">
                            <div class="action-buttons">
                                <a class="btn btn-dark btn-sm"
                                   href="<?php echo e(route('user.order.details', $order->id)); ?>">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card">
                <div class="card-body text-center p-4">

                    <svg width="40" height="40" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.699126 22.1299L11.4851 0.936473C11.6065 0.697285 11.7856 0.49768 12.0036 0.358621C12.2215 0.219562 12.4703 0.146179 12.7237 0.146179C12.9772 0.146179 13.2259 0.219562 13.4439 0.358621C13.6618 0.49768 13.841 0.697285 13.9624 0.936473L24.7483 22.1299C24.8658 22.3607 24.9253 22.6205 24.9209 22.8835C24.9165 23.1466 24.8484 23.4039 24.7234 23.6301C24.5983 23.8562 24.4206 24.0434 24.2078 24.1732C23.995 24.303 23.7543 24.3708 23.5097 24.3701H1.93781C1.69314 24.3708 1.45252 24.303 1.23968 24.1732C1.02684 24.0434 0.849131 23.8562 0.724084 23.6301C0.599037 23.4039 0.530969 23.1466 0.526592 22.8835C0.522216 22.6205 0.581682 22.3607 0.699126 22.1299ZM14.2252 14.2749L14.9815 9.39487C15.0039 9.25037 14.9967 9.10237 14.9605 8.96116C14.9243 8.81995 14.8599 8.6889 14.7719 8.57713C14.6838 8.46536 14.5742 8.37554 14.4506 8.31391C14.327 8.25228 14.1925 8.22033 14.0563 8.22026H11.3912C11.255 8.22033 11.1204 8.25228 10.9969 8.31391C10.8733 8.37554 10.7637 8.46536 10.6756 8.57713C10.5876 8.6889 10.5232 8.81995 10.487 8.96116C10.4508 9.10237 10.4436 9.25037 10.466 9.39487L11.2223 14.2749H14.2252ZM14.7882 18.1096C14.7882 17.5208 14.5707 16.9561 14.1835 16.5398C13.7964 16.1234 13.2713 15.8895 12.7237 15.8895C12.1762 15.8895 11.6511 16.1234 11.2639 16.5398C10.8768 16.9561 10.6593 17.5208 10.6593 18.1096C10.6593 18.6984 10.8768 19.2631 11.2639 19.6794C11.6511 20.0957 12.1762 20.3296 12.7237 20.3296C13.2713 20.3296 13.7964 20.0957 14.1835 19.6794C14.5707 19.2631 14.7882 18.6984 14.7882 18.1096Z" fill="#EA4335"/>
                    </svg>
                    <br><br>

                    <h6>No data found</h6>



                </div>
            </div>
        <?php endif; ?>
    </div>

        <div class="col d-flex justify-content-start" style="padding-bottom: 20px">
            <?php echo e(paginateLinks($orders)); ?>

        </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/user/orders.blade.php ENDPATH**/ ?>