<div class="ffp_payment_info">
    <div class="ffp_payment_info_item ffp_payment_info_item_order_id">
        <div class="ffp_item_heading"><?php _e('Order ID:', 'flentformpro');?></div>
        <div class="ffp_item_value">#<?php echo $submission->id; ?></div>
    </div>
    <div class="ffp_payment_info_item ffp_payment_info_item_date">
        <div class="ffp_item_heading"><?php _e('Date:');?></div>
        <div class="ffp_item_value"><?php echo date(get_option( 'date_format' ), strtotime($submission->created_at)); ?></div>
    </div>
    <div class="ffp_payment_info_item ffp_payment_info_item_total">
        <div class="ffp_item_heading"><?php _e('Total:');?></div>
        <div class="ffp_item_value"><?php echo $orderTotal; ?></div>
    </div>
    <?php if($submission->payment_method): ?>
        <div class="ffp_payment_info_item ffp_payment_info_item_payment_method">
            <div class="ffp_item_heading"><?php _e('Payment Method:');?></div>
            <div class="ffp_item_value"><?php echo ucfirst($submission->payment_method); ?></div>
        </div>
    <?php endif; ?>
    <?php if($submission->payment_status): ?>
        <div class="ffp_payment_info_item ffp_payment_info_item_payment_status">
            <div class="ffp_item_heading"><?php _e('Payment Status:');?></div>
            <div class="ffp_item_value"><?php echo ucfirst($submission->payment_status); ?></div>
        </div>
    <?php endif; ?>
</div>