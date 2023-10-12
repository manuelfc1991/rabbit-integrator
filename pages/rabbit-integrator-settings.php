<div class="rabbit-integrator-admin-row">
  <div class="rabbit-integrator-admin-form rabbit-integrator-admin-settings">
    <h4>PayPal Settings</h4>
    <form method="post" name="rabbit-integrator-template-new" id="rabbit-integrator-settings" class="rabbit-integrator-template-new" >
      <ul>
        <li>
          <label for="paypal-id">PayPal ID</label>
          <input type="text" class="validate-field" data-validation-mandatory="yes" data-validation-type="email" name="paypal_id" id="paypal-id" placeholder="example@gmail.com" value="<?php echo $paypal_id; ?>" >
        </li>
        <li>
          <label for="server">Server</label>
          <select class="validate-field" data-validation-mandatory="yes" data-validation-type="text" name="server" id="server" value="">
            <option value="sandbox" <?php if($server == 'sandbox') { ?>selected<?php } ?>>Sandbox</option>
            <option value="live" <?php if($server == 'live') { ?>selected<?php } ?>>Live</option>
          </select>
        </li>
        <li>
          <label for="success-url">Success URL</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="success_url" id="success-url" placeholder="example.com/success/" value="<?php echo $success_url; ?>" >
        </li>
        <li>
          <label for="return-url">Return URL</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="return_url" id="return-url" placeholder="example.com/return/" value="<?php echo $return_url; ?>" >
        </li>
        <li>
          <label for="notify-url">Notify URL</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="notify_url" id="notify-url" placeholder="example.com/notify/" value="<?php echo $notify_url; ?>" >
        </li>
        <li>
          <label for="currency">Currency</label>
          <select class="validate-field" data-validation-mandatory="yes" data-validation-type="text" name="currency" id="currency" >
            <option value="USD" <?php if($currency == 'USD') { ?>selected<?php } ?>>United States Dollar (USD)</option>
            <option value="EUR" <?php if($currency == 'EUR') { ?>selected<?php } ?>>Euro (EUR)</option>
            <option value="GBP" <?php if($currency == 'GBP') { ?>selected<?php } ?>>British Pound Sterling (GBP)</option>
          </select>
        </li>
        <li>
          <label for="tax">Tax</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int_>=_0" name="tax" id="tax" placeholder="%" value="<?php echo $tax; ?>">
        </li>
        <li>
          <input type="submit" name="rabbit-submit-btn" class="rabbit-integrator-button" id="rabbit-integrator-paypal-submit" value="Submit">
        </li>
      </ul>
    </form>
  </div>
</div>