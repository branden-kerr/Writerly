<ul class="ffp_payment_info_table">
    <li>
        <b><?php _e('Amount:', 'flentformpro');?></b> <?php echo $orderTotal; ?></b>
    </li>
    <?php if($submission->payment_method): ?>
        <li>
            <b><?php _e('Payment Method:', 'flentformpro');?></b> <?php echo ucfirst($submission->payment_method); ?></b>
        </li>
    <?php endif; ?>
    <?php if($submission->payment_status): ?>
        <li>
            <b><?php _e('Payment Status:', 'flentformpro');?></b> <?php echo ucfirst($submission->payment_status); ?></b>
        </li>
    <?php endif; ?>
</ul>