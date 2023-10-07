<!-- <div class="rabbit-integrator-admin-new-template-wrap">
  <div class="rabbit-integrator-admin-new-template">
    <form method="post" name="programmatic-seo-frm-post-template-new" id="programmatic-seo-frm-post-template-new" class="programmatic-seo-frm-post-template-new" >
      <table class="form-table" role="presentation">
        <tbody>
          <tr class="form-field form-required">
            <th scope="row"><label for="title">Title <span class="mandatory">*</span></label></th>
            <td><input name="title" type="text" id="title" value="" aria-required="true" autocapitalize="none" autocorrect="off"  ></td>
          </tr>  
          <tr class="form-field">
              <th scope="row"></th>
              <td>
                <p class="submit"><input type="submit" name="submit-btn" class="button button-primary" value="Submit"></p>
              </td>
          </tr>   
          </tbody>
      </table>
    </form>
  </div>
  <div class="rabbit-integrator-admin-new-template-demo">
      <button class="rabbit-integrator-paypal-btn">Paypal</button>
  </div>
</div> -->
<div class="rabbit-integrator-admin-row">
  <div class="rabbit-integrator-admin-form">
    <h4>New PayPal Button</h4>
    <form method="post" name="rabbit-integrator-template-new" id="rabbit-integrator-template-new" class="rabbit-integrator-template-new" >
      <ul>
        <li>
          <label for="title">Title</label>
          <input type="text" class="validate-field" data-validation-mandatory="yes" data-validation-type="text" name="title" id="title" value="" >
        </li>
        <li>
          <label for="price">Price</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="float" name="price" id="price" value="" >
        </li>
        <li>
          <label for="button-text">Button Text</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_text" id="button-text" >
        </li>
        <li>
          <label for="button-text-size">Button Text Size</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="button_text_size" id="button-text-size" value="" >
        </li>
        <li>
          <label for="button-width">Button Width</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="button_width" id="button-width" value="" >
        </li>
        <li>
          <label for="button-height">Button Height</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="button_height" id="button-height" value="" >
        </li>
        <li>
          <label for="button-text-color">Button Text Color</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_text_color" id="button-text-color" value="" >
        </li>
        <li>
          <label for="button-color">Button Color</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_color" id="button-color" value="" >
        </li>
          <input type="submit" name="rabbit-submit-btn" class="rabbit-integrator-button" id="rabbit-integrator-paypal-submit" value="Submit">
        </li>
      </ul>
    </form>
  </div>
  <div class="rabbit-integrator-admin-paypal-demo">
    <div class="rabbit-integrator-admin-paypal-demo-inner">
        <div class="rabbit-integrator-paypal-paragraph">The frontend paypal button has the following appearance:</div>
        <div class="rabbit-integrator-paypal-btn-wrap">
          <button class="rabbit-integrator-paypal-btn"><span>Continue With</span><img src="<?php echo RI_PLUGIN_URL; ?>assets/images/paypal.png"></button>
        </div>
      </div>
    </div>
</div>

        <!-- <li>
          <label for="currency">Currency</label>
          <select name="currency" id="currency">
            <option value="USD">United States Dollar (USD)</option>
            <option value="EUR">Euro (EUR)</option>
            <option value="GBP">British Pound Sterling (GBP)</option>
          </select>
        </li> -->