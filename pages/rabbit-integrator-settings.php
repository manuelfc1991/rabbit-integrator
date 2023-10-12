<div class="rabbit-integrator-admin-row">
  <div class="rabbit-integrator-admin-form rabbit-integrator-admin-settings">
    <h4>PayPal Settings</h4>
    <form method="post" name="rabbit-integrator-template-new" id="rabbit-integrator-template-new" class="rabbit-integrator-template-new" >
      <ul>
        <li>
          <label for="paypal-id">PayPal ID</label>
          <input type="text" class="validate-field" data-validation-mandatory="yes" data-validation-type="email" name="paypal_id" id="paypal-id" placeholder="example@gmail.com" value="" >
        </li>
        <li>
          <label for="server">Server</label>
          <select class="validate-field" data-validation-mandatory="yes" data-validation-type="text" name="currency" id="currency" value="">
            <option value="sandbox">Sandbox</option>
            <option value="live">Live</option>
          </select>
        </li>
        <li>
          <label for="success-url">Success URL</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="success_url" id="success-url" placeholder="example.com/success/" value="" >
        </li>
        <li>
          <label for="return-url">Return URL</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="return_url" id="return-url" placeholder="example.com/return/" value="" >
        </li>
        <li>
          <label for="notify-url">Notify URL</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="notify_url" id="notify-url" placeholder="example.com/notify/" value="" >
        </li>
        <li>
          <label for="currency">Currency</label>
          <select class="validate-field" data-validation-mandatory="yes" data-validation-type="text" name="currency" id="currency" value="">
            <option value="USD">United States Dollar (USD)</option>
            <option value="EUR">Euro (EUR)</option>
            <option value="GBP">British Pound Sterling (GBP)</option>
          </select>
        </li>
        <li>
          <label for="button-text">Tax</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_text" id="button-text" placeholder="%">
        </li>
        <li>
          <input type="submit" name="rabbit-submit-btn" class="rabbit-integrator-button" id="rabbit-integrator-paypal-submit" value="Submit">
        </li>
      </ul>
    </form>
  </div>
</div>