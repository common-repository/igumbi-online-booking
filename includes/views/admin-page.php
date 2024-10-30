
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
  <h2>
    <?php echo __('igumbi Online Booking Tool Embedding Page','igumbi-online-booking')?></h2>
  <p style="width:890px;">
    <?php echo __('Our plugin helps with direct online bookings for small hotels, apartments & holiday flats. Seamlessly integrated with WordPress, it generates online bookings, invoiced & paid via Stripe, simplifying the process for owners & guests. Delight in a user-friendly, efficient solution for managing reservations and increasing occupancy.','igumbi-online-booking')?>
  </p>
  <form method="post" action="options.php">
    <?php settings_fields('igumbi_settings')?>
    <?php do_settings_sections('igumbi_settings_section')?>
    <table style="max-width:890px;">
      <tr valign="top">
        <td style="width: 160px; padding: 4px 4px 8px 4px;">
          <?php
            echo __('igumbi Hotel Code','igumbi-online-booking')?>:</td>
        <td style="padding: 4px 4px 8px 4px;">
          <input name="igumbi_hotel_id" type="text" id="igumbi_hotel_id" size=6 maxlength=100 style="width:120px;padding:4px 8px;text-align:center;font-size:16px;"
          value="<?php echo get_option('igumbi_hotel_id'); ?>"/>
        <p class="description"><?php
          echo __('You will find the 7 character <b>hotel code</b> on the igumbi <a href="https://www.igumbi.net/settings/mine?locale=en&utm_campaign=wpplugin&utm_source=adminpage&utm_medium=link">settings page</a>.<br/> To see it you need an account and need to be logged in at <a href="https://www.igumbi.net/login?locale=en&utm_campaign=wpplugin&utm_source=adminpage&utm_medium=link">igumbi</a>.<br/>Create a new <a href="https://www.igumbi.com/trial?locale=en&utm_campaign=wpplugin&utm_source=adminpage&utm_medium=link">trial account</a>.','igumbi-online-booking')?>
        </td>

      </tr>
      <tr valign="top">
        <td style="width: 160px; padding: 4px 4px 8px 4px;"><?php
        echo __('igumbi Language Code','igumbi-online-booking')?>:</td>
        <td style="padding: 4px 4px 8px 4px;">
          <select id="igumbi_language" name="igumbi_language" style="width:120px;">
            <?php
              $langs = array("de","en","gr","ru","es","nl","jp","de_du");
              foreach($langs as $lang) {
                echo "<option value = " . $lang . " ";
                if(get_option("igumbi_language") == $lang) echo 'selected="selected"';
                echo ">" . $lang . "</option>";
              }
            ?>
          </select>
          <p class="description">
            <?php
            echo __('Language: ISO code, Supported languages are de, en, gr, ru, es, nl, jp, de_du','igumbi-online-booking')?>
          </p>
        </td>
      </tr>

      <tr valign="top">
        <td style="width: 160px; padding: 4px 4px 8px 4px;">
          <?php
          echo __('igumbi Layout','igumbi-online-booking')?>:</td>
        <td style="padding: 4px 4px 8px 4px;">
          <select id="igumbi_wide" name="igumbi_wide" style="width:120px;">
            <option value="2" <?php if(get_option('igumbi_wide') == 2) echo "selected='selected'";?>>wide2</option>
            <option value="0" <?php if(get_option('igumbi_wide') == 0) echo "selected='selected'";?>>tall</option>
            <option value="1" <?php if(get_option('igumbi_wide') == 1) echo "selected='selected'";?>>wide</option>
          </select>
         <p class="description">
           <?php
           echo __('<b>tall or wide/wide2 mode</b><br/> <b>wide2</b> is the default for responsive single column templates (Twenty Twenty, Twenty twenty-One... Twenty-Twenty-Three). <br/>The <b>tall</b> mode should be used in the older templates sidebar as a widget. <br/> The <b>wide</b> mode you integrate into the header or the top of the body via the shortcode [igumbi_avform].','igumbi-online-booking')?>
         </p>
        </td>
      </tr>

      <tr valign="top">
        <td style="width: 160px; padding: 4px 4px 8px 4px;"><?php
        echo __('igumbi Responsive Mode','igumbi-online-booking')?>:</td>
        <td style="padding: 4px 4px 8px 4px;">
          <select id="igumbi_responsive" name="igumbi_responsive" style="width:120px;">
            <option value="0" <?php if(get_option('igumbi_responsive') == 0) echo "selected='selected'";?>>classic</option>
            <option value="1" <?php if(get_option('igumbi_responsive') == 1) echo "selected='selected'";?>>responsive</option>
          </select>
         <p class="description">
           <?php
           echo __("Responsive Mode: When you choose the 'responsive' mode over the 'classic' mode you get a stripped down CSS file and you need to ensure that you handle the styling of your buttons to go with your theme.",'igumbi-online-booking')?>
         </p>
        </td>
      </tr>

      <tr valign="top">
        <td style="width: 160px; padding: 4px 4px 8px 4px;">igumbi Custom CSS:</td>
        <td style="padding: 4px 4px 8px 4px;">
          <textarea id="igumbi_custom_css" name="igumbi_custom_css" style="width:600px;height:250px;"><?php echo get_option('igumbi_custom_css');?></textarea>
         <p class="description">
           <?php
           echo __("You can overwrite the CSS provided by the igumbi booking tool. Check the <a href='https://www.igumbi.com/stylesheets/seller.css' target='_blank'>basic CSS</a> (mostly width and dimensions),<br/> the <a href='https://www.igumbi.com/stylesheets/sellerci.css' target='_blank'>button and colors CSS</a> and the <a href='https://www.igumbi.com/stylesheets/date.css' target='_blank'>date popup CSS</a> files.",'igumbi-online-booking')?>
         </p>
        </td>
      </tr>

      <tr valign="top">
        <td colspan="2" style="padding: 4px 4px 8px 4px;">
          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="igumbi_hotel_id,igumbi_language,igumbi_wide,igumbi_custom_css,igumbi_responsive" />
          <input type="submit" value="<?php _e('Save Changes') ?>" class="button button-primary" />
        </td>
      </tr>
    </table>
  </form>

  <div style="width:890px;">
    <h2>
      <?php
      echo __("Getting started with the online booking tool (IBE)",'igumbi-online-booking')?>:
    </h2>
    <ol>
      <li>
        <?php
        echo __("Sign-up for a <a href='https://www.igumbi.com/trial?locale=en&utm_campaign=wpplugin&utm_source=adminpage&utm_medium=link' class='button button-primary'>igumbi trial account</a> and enter the settings above.",'igumbi-online-booking')?>
      </li>
      <li>
        <?php
        echo __("Set up your property in igumbi: at least describe your productcategories and load a picture for each productcategory. Ensure your bookings have been entered so that the correct availability can be calculated before setting the booking tool live on the website.",'igumbi-online-booking')?>
      </li>
      <li>
        <?php
      echo __("Page with Shortcodes: You can place the elements individually by creating a page in WordPress and enter these <b>shortcodes: [igumbi_avform] and [igumbi_dialog]</b>. You can customize the avform with parameters like [igumbi_avform lang=es] to handle different languages.<br/><pre>[igumbi_avform]<br/>[igumbi_dialog]</pre>",'igumbi-online-booking')?>
      </li>
      <li>
        <?php
        echo __("Theme: Optionally add the shortcode [igumbi_avform] and [igumbi_dialog] to your theme. Usually it is placed first item after <br/> <code>&lt;div id='content' role='main'&gt;</code> with <code>&lt;?php echo do_shortcode('[igumbi_dialog]');?&gt;</code>.<br/>This is where the response from the booking tool will land after an availability request has been made.",'igumbi-online-booking')?>
        <pre>
&lt;?php echo do_shortcode('[igumbi_avform]');?&gt;
&lt;?php echo do_shortcode('[igumbi_dialog]');?&gt;
        </pre>
      </li>

      <li>
        <?php
        echo __("Widget: The widget to start the booking-flow (arrival date, departure date, number of rooms, number of persons persons) can be added to the widget sidebar. The placement of the booking tool output is your main content area.",'igumbi-online-booking')?>
      </li>
      <li>
        <?php
        echo __("Add the [igumbi_avform] to the sidebar widgets. Menu Appearance >> Widgets and pull it to the top under/above search - move it up high in the sidebar, as it is probably your primary conversion goal to drive bookings with your WordPress Site.",'igumbi-online-booking')?>
      </li>
      <li>
        <?php
        echo __("Payments with creditcard: You can use <b>Stripe for payment processing</b> of the bookings. Contact <a href='mailto:support@igumbi.com?subject=Wordpress%20Plugin%20Stripe'>igumbi Support</a> for activation and a walkthrough of the options.<br/> Here is a <a href='https://www.igumbi.com/de/support/kreditkartenzahlung-mit-stripe'>German support article</a> explaining the igumbi - Stripe integration.",'igumbi-online-booking')?>
      </li>
    </ol>
    <?php echo productcategorylist();?>
  </div>

</div>
