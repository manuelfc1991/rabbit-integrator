<div class="rabbit-integrator-admin-row">
  <div class="rabbit-integrator-admin-form">
    <?php if($data_flag) { ?><h4>Edit PayPal Button</h4><?php } else { ?><h4>New PayPal Button</h4><?php } ?>
    <form method="post" name="rabbit-integrator-template-new" id="rabbit-integrator-template-new" class="rabbit-integrator-template-new <?php if($data_flag) { ?>rabbit-integrator-template-edit<?php } if ($cpy_flag) { ?> rabbit-integrator-template-cpy<?php } ?>" >
      <ul>
        <li>
          <label for="title">Title</label>
          <input type="text" class="validate-field" data-validation-mandatory="yes" data-validation-type="text" name="title" id="title" value="<?php echo $title; ?>" >
        </li>
        <li>
          <label for="price">Price</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="number" name="price" id="price" value="<?php echo $price; ?>" >
        </li>
        <li>
          <label for="button-text">Button Text</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_text" id="button-text" value="<?php echo $button_text; ?>">
        </li>
        <li>
          <label for="button-text-size">Button Text Size</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="button_text_size" id="button-text-size" value="<?php echo $button_text_size; ?>" >
        </li>
        <li>
          <label for="button-width">Button Width</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="button_width" id="button-width" value="<?php echo $button_width; ?>" >
        </li>
        <li>
          <label for="button-height">Button Height</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="int" name="button_height" id="button-height" value="<?php echo $button_height; ?>" >
        </li>
        <li>
          <label for="button-text-color">Button Text Color</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_text_color" id="button-text-color" value="<?php echo $button_text_color; ?>" >
        </li>
        <li>
          <label for="button-color">Button Color</label>
          <input type="text" class="validate-field" data-validation-mandatory="no" data-validation-type="text" name="button_color" id="button-color" value="<?php echo $button_color; ?>" >
        </li>
        <li>
          <?php if($data_flag) { ?>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
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