<?php $__env->startSection('content'); ?>

    <div class="container">

        <div class="row p-3">
            <div class="col-12">
                <form action="<?php echo e(route('user.deposit.insert')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

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

                    <p class="mt-3 p-3">Top up your wallet easily using Bank Transfer or Card</p>


                    <div class="card">

                        <div class="card-body">
                            <h6>Enter Amount (NGN)</h6>
                            <input placeholder="Enter amount" type="number" name="amount"
                                   class="text-dark p-2 form-control" required>
                            <input type="text" hidden value="enkpay" name="payment">


                        </div>

                    </div>


                    <div class="card">

                        <div class="card-body">
                            <h6 class="mb-1 mt-1">Select Payment Gateway</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="col-12">
                                    <select class="text-dark form-control2 p-2" name="gateway" required>
                                        <option value="">Select payment method</option>
                                        <?php if($card > 0 ): ?>
                                            <?php
                                                $cardNumber = $vcard->card_no;
                                                $maskedCardNumber = substr($cardNumber, 0, 5) . str_repeat('*', 7) . substr($cardNumber, -4);
                                            ?>
                                            <option value="card">Pay with linked card <?php echo e($maskedCardNumber); ?></option>
                                        <?php else: ?>
                                        <?php endif; ?>
                                        <option value="250">Instant Payment</option>
                                        <option value="1000">Manual Payment</option>
                                    </select>

                                </div>
                            </div>




                        </div>








                    </div>





                    <button type="submit"
                            style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                            class="btn  w-100 mt-3" id="btn-confirm"><?php echo app('translator')->get('Pay Now'); ?>
                    </button>

                    <hr>

                    <a  href="https://web.enkpay.com/resolve?user_id=5574464544883353533&check_url=https://logmarketplace.careerbridgecop.com/public/api/verify" class="btn btn-dark w-100 my-2">Having Payment issues? Resolve here</a>


                </form>


            </div>


            <div class="col-md-12">
                <h5 class="mt-4 mb-4"><?php echo app('translator')->get('Latest Payments History'); ?></h5>
                <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <div class="card">
                        <div class="card-body " style="font-size: 11px;">
                            <div class="row">
                                <div class="col-3">
                                    <h6><?php echo e(number_format($deposit->amount, 2)); ?></h6>
                                </div>

                                <div class="col">
                                    <?php echo e(diffForHumans($deposit->created_at)); ?>

                                </div>


                                <div class="col">
                                    <?php if($deposit->method_code == 1000): ?>
                                        <a href="javascript:void(0);"
                                           class="item- text-small d-flex justify-content-end">
                                            <?php if($deposit->status == 1): ?>
                                                <a href="#" class="btn btn-success btn-sm">Completed</a>
                                            <?php elseif($deposit->status == 2): ?>
                                                <a href="#" class="btn btn-warning btn-sm">Pending</a>
                                            <?php elseif($deposit->status == 3): ?>
                                                <a href="#" class="btn btn-danger btn-sm">Rejected</a>
                                            <?php else: ?>
                                                <a href="#" class="btn btn-warning btn-sm">Pending</a>
                                            <?php endif; ?>

                                        </a>
                                    <?php elseif($deposit->method_code == 250): ?>
                                        <a href="javascript:void(0);" class="item-bookmark">
                                            <?php if($deposit->status == 1): ?>
                                                <a href="#" class="btn btn-success btn-sm">Completed</a>
                                            <?php elseif($deposit->status == 2): ?>

                                            <?php elseif($deposit->status == 3): ?>
                                                <a href="#" class="btn btn-danger btn-sm">Rejected</a>
                                            <?php else: ?>

                                            <?php endif; ?>

                                        </a>
                                    <?php else: ?>
                                        <?php if($deposit->status == 1): ?>
                                            <span class="text-small col-sm-12 badge bg-success mb-1">Successful</span>
                                        <?php elseif($deposit->status == 2): ?>
                                            <span class="text-small col-sm-12 badge bg-warning mb-1">Pending</span>
                                        <?php elseif($deposit->status == 3): ?>
                                            <span class="text-small col-sm-12 badge bg-danger mb-1">Canceled</span>
                                        <?php else: ?>
                                            <span class="text-small col-sm-12 badge bg-warning mb-1">Pending</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="card">
                        <div class="card-body text-center p-4">

                            <svg width="40" height="40" viewBox="0 0 25 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.699126 22.1299L11.4851 0.936473C11.6065 0.697285 11.7856 0.49768 12.0036 0.358621C12.2215 0.219562 12.4703 0.146179 12.7237 0.146179C12.9772 0.146179 13.2259 0.219562 13.4439 0.358621C13.6618 0.49768 13.841 0.697285 13.9624 0.936473L24.7483 22.1299C24.8658 22.3607 24.9253 22.6205 24.9209 22.8835C24.9165 23.1466 24.8484 23.4039 24.7234 23.6301C24.5983 23.8562 24.4206 24.0434 24.2078 24.1732C23.995 24.303 23.7543 24.3708 23.5097 24.3701H1.93781C1.69314 24.3708 1.45252 24.303 1.23968 24.1732C1.02684 24.0434 0.849131 23.8562 0.724084 23.6301C0.599037 23.4039 0.530969 23.1466 0.526592 22.8835C0.522216 22.6205 0.581682 22.3607 0.699126 22.1299ZM14.2252 14.2749L14.9815 9.39487C15.0039 9.25037 14.9967 9.10237 14.9605 8.96116C14.9243 8.81995 14.8599 8.6889 14.7719 8.57713C14.6838 8.46536 14.5742 8.37554 14.4506 8.31391C14.327 8.25228 14.1925 8.22033 14.0563 8.22026H11.3912C11.255 8.22033 11.1204 8.25228 10.9969 8.31391C10.8733 8.37554 10.7637 8.46536 10.6756 8.57713C10.5876 8.6889 10.5232 8.81995 10.487 8.96116C10.4508 9.10237 10.4436 9.25037 10.466 9.39487L11.2223 14.2749H14.2252ZM14.7882 18.1096C14.7882 17.5208 14.5707 16.9561 14.1835 16.5398C13.7964 16.1234 13.2713 15.8895 12.7237 15.8895C12.1762 15.8895 11.6511 16.1234 11.2639 16.5398C10.8768 16.9561 10.6593 17.5208 10.6593 18.1096C10.6593 18.6984 10.8768 19.2631 11.2639 19.6794C11.6511 20.0957 12.1762 20.3296 12.7237 20.3296C13.2713 20.3296 13.7964 20.0957 14.1835 19.6794C14.5707 19.2631 14.7882 18.6984 14.7882 18.1096Z"
                                    fill="#EA4335"/>
                            </svg>
                            <br><br>

                            <h6>No data found</h6>


                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/user/deposit_new.blade.php ENDPATH**/ ?>