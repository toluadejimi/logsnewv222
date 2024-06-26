<div id="purchaseModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <?php if(auth()->guard()->check()): ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><?php echo app('translator')->get('Purchase'); ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('user.deposit.insert')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <input type="hidden" name="currency">
                    <div class="modal-body"> 
                        <div class="small">
                            <p class="text mb-3"></p>
                            <ul class="list-group list-group-flush preview-details">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><?php echo app('translator')->get('In Stock'); ?></span>
                                    <span class="pcs"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><?php echo app('translator')->get('Per Quantity'); ?></span>
                                    <span class="amount"></span>
                                </li>
                                
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><?php echo app('translator')->get('Payable'); ?></span> <span><span class="payable fw-bold"> 0</span> <?php echo e(__($general->cur_text)); ?></span>
                                </li>
                                <li class="list-group-item justify-content-between d-none rate-element">
                                </li>
                                <li class="list-group-item justify-content-between d-none in-site-cur">
                                    <span><?php echo app('translator')->get('In'); ?> <span class="method_currency"></span></span>
                                    <span class="final_amo fw-bold">0</span>
                                </li>
                                <li class="list-group-item justify-content-center crypto_currency d-none">
                                    <span><?php echo app('translator')->get('Conversion with'); ?> <span class="method_currency"></span> <?php echo app('translator')->get('and final value will Show on next step'); ?></span>
                                </li>
                            </ul>
                        </div>

                        <div class="row mt-4">
                            <div class="form-group col-md-6">
                                <label class="form--label"><?php echo app('translator')->get('Payment Method'); ?></label>
                                <select class="form--control form-select" name="gateway" required>
                                    <?php $__currentLoopData = $gatewayCurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($data->method_code); ?>" data-gateway="<?php echo e($data); ?>"><?php echo e($data->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form--label"><?php echo app('translator')->get('Quantity'); ?></label>
                                <input type="number" name="qty" class="form--control" value="1" required>
                                <input type="text" name="payment" value="wallet" hidden>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-0 m-0 border-top-0">
                        <button type="submit" class="btn btn--base w-100 m-0"><i class="fas fa-angle-double-right"></i> <?php echo app('translator')->get('Buy Now'); ?></button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="modal-content">
                <div class="modal-header"> 
                    <h6 class="modal-title method-name"><?php echo app('translator')->get('Login required'); ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('In order to buy a product, you need to log in to your account'); ?></p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo e(route('user.login', ['redirect'=>request()->fullUrl()])); ?>" class="btn btn-sm btn--base w-100"><?php echo app('translator')->get('Login'); ?></a>
                </div>
            </div> 
        <?php endif; ?>
    </div>
</div> 

<?php if(auth()->guard()->check()): ?>
    <?php $__env->startPush('style'); ?>
        <style>
            .list-group-flush>.list-group-item:last-child{
                border-bottom-width: thin !important;
            }

            #purchaseModal .modal-content {
                border: 0 !important;
            }

            #purchaseModal .modal-body,
            #purchaseModal .modal-body .text {
                font-size: 0.875rem !important;
            }
            
            #purchaseModal .modal-footer .btn.w-100 {
                border-radius: 0 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('script'); ?>
        <script>
            (function ($) {
                "use strict";
                var baseAmount = 0;

                $('.purchaseBtn').on('click', function () {
                    var modal = $('#purchaseModal');

                    baseAmount = parseFloat($(this).data('amount'));
            
                    var text = $(this).data('text');
                    var price = $(this).data('price');
                    var qty = $(this).data('qty');
                    var id = $(this).data('id');

                    modal.find('.text').text(text);
                    modal.find('.amount').text(price);
                    modal.find('.pcs').text(qty);
                    modal.find('[name=id]').val(id);

                    $('[name=qty]').attr('max', parseInt(qty));
                    modal.modal('show');
                });

                $('select[name=gateway]').change(function(){

                    if(!$('select[name=gateway]').val()){
                        return false;
                    }

                    var resource = $('select[name=gateway] option:selected').data('gateway');
                    var fixed_charge = parseFloat(resource.fixed_charge);
                    var percent_charge = parseFloat(resource.percent_charge);
                    var rate = parseFloat(resource.rate)

                    if(resource.method.crypto == 1){
                        var toFixedDigit = 8;
                        $('.crypto_currency').removeClass('d-none');
                    }else{
                        var toFixedDigit = 2;
                        $('.crypto_currency').addClass('d-none');
                    }

                    $('.min').text(parseFloat(resource.min_amount).toFixed(2));
                    $('.max').text(parseFloat(resource.max_amount).toFixed(2));

                    var qty = parseFloat($('input[name=qty]').val());

                    if (isNaN(qty)) {
                        qty = 0;
                    }

                    var amount = (baseAmount * qty);

                    if (!amount) {
                        amount = 0;
                    }

                    if(amount <= 0){
                        return false;
                    }

                    var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                    $('.charge').text(charge);
                    var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                    $('.payable').text(payable);
                    var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge)))*rate).toFixed(toFixedDigit);
                    $('.final_amo').text(final_amo);
                    
                    if (resource.currency != '<?php echo e($general->cur_text); ?>') {
                        var rateElement = `<span class="fw-bold"><?php echo app('translator')->get('Conversion Rate'); ?></span> <span><span  class="fw-bold">1 <?php echo e(__($general->cur_text)); ?> = <span class="rate">${rate}</span>  <span class="method_currency">${resource.currency}</span></span></span>`;
                        $('.rate-element').html(rateElement)
                        $('.rate-element').removeClass('d-none');
                        $('.in-site-cur').removeClass('d-none');
                        $('.rate-element').addClass('d-flex');
                        $('.in-site-cur').addClass('d-flex');
                    }else{
                        $('.rate-element').html('')
                        $('.rate-element').addClass('d-none');
                        $('.in-site-cur').addClass('d-none');
                        $('.rate-element').removeClass('d-flex');
                        $('.in-site-cur').removeClass('d-flex');
                    }
                    $('.method_currency').text(resource.currency);
                    $('input[name=currency]').val(resource.currency);
                    $('input[name=qty]').on('input');
                });

                $('input[name=qty]').on('input',function(){
                    $('select[name=gateway]').change();
                });
            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php else: ?> 
    <?php $__env->startPush('script'); ?>
        <script>
            (function ($) {
                "use strict";
                $('.purchaseBtn').on('click', function () {
                    var modal = $('#purchaseModal');
                    modal.modal('show');
                });
            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/aacelogs/core/resources/views/components/purchase-modal.blade.php ENDPATH**/ ?>