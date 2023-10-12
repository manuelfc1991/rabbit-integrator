<?php
/******************************************************************************* 
 *  11-03-2021 code updated
 *******************************************************************************
*/
class paypal 
{
	function __construct()
	{
     $this->css_path = RI_PLUGIN_URL.'/assets/css/';
     $this->image_path = RI_PLUGIN_URL.'/assets/images/';
	  $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	  $this->paypal_ipn_url = 'https://ipnpb.paypal.com/cgi-bin/webscr';
	  $this->last_error = '';
	  $this->ipn_log_file = '../ipn_results.log';
	  $this->ipn_log = true; 
	  $this->ipn_response = '';
	  $this->ipn_data = array(); 
	  $this->fields = array(); 
	  
	  $this->add_field('rm','2');           
	  $this->add_field('cmd','_xclick'); 
  
   }
// add paypal variables.  If the value is already in the array, it will be overwritten.
   function add_field($field, $value) 
   {
      $this->fields["$field"] = $value;
   }
// creates paypal auto submiting form with provide variables
   function submit_paypal_post($page_type = "") 
   {
      $html_r = " <form method=\"post\" name=\"paypal_form\" action=\"".$this->paypal_url."\">";
      foreach ($this->fields as $name => $value) { $html_r.= " <input type=\"hidden\" name=\"$name\" value=\"$value\"/>"; }
      $html_r.= " <input type=\"submit\" value=\"Payment\" class=\"rabbit-integrator-processing-paypal-btn\"> </form>";
      if($page_type == "full")
	  {
		//   $html_r1 = " <html> <head><title>Processing Payment...</title></head> <body onLoad=\"document.forms['paypal_form'].submit();\">";
		  $html_r1 = '<div class="rabbit-integrator-processing-wrap-outer">';
		  $html_r1.= '<div class="rabbit-integrator-processing-wrap" >'; 
        $html_r1.= ' <div class="rabbit-integrator-processing-loader"><img src="'.$this->image_path.'loader.svg" width="90" ></div>';
		  $html_r1.= ' <div class="rabbit-integrator-processing-content">If you are not automatically redirected to paypal within few seconds please click payment button.</div>';
		  $html_r1.= ' <div class="rabbit-integrator-processing-from">'.$html_r.'</div>';
		  $html_r1.= '</div></div>';
        return $html_r1; 
	  }
	  else
	  {
	  	  return $html_r;
	  }
   }
// validate ipn response
   function validate_ipn() {

      // parse the paypal URL
      $url_parsed=parse_url($this->paypal_url);        

      // generate the post string from the _POST vars aswell as load the
      // _POST vars into an arry so we can play with them from the calling
      // script.
      $post_string = '';    
      foreach ($_POST as $field=>$value) { 
         $this->ipn_data["$field"] = $value;
         $post_string.= $field.'='.urlencode(stripslashes($value)).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command

      // open the connection to paypal
	  $scheme = '';
	  $port = 80;
	  if($url_parsed['scheme']=='https')
	  {
		  $scheme = 'ssl://';
		  $port = 443;
	  }
	  
      $fp = fsockopen($scheme.$url_parsed['host'], $port, $errnum, $errstr, 30);; 
      if(!$fp) {
          
         // could not open the connection.  If loggin is on, the error message
         // will be in the log.
         $this->last_error = "fsockopen error no. $errnum: $errstr";
         $this->log_ipn_results(false);       
         return false;
         
      } else { 
 
         // Post the data back to paypal
         fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
         fputs($fp, "Host: $url_parsed[host]\r\n"); 
         fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
         fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
         fputs($fp, "Connection: close\r\n\r\n"); 
         fputs($fp, $post_string . "\r\n\r\n"); 
         // loop through the response from the server and append to variable
         while(!feof($fp)) { 
            $this->ipn_response.= fgets($fp, 1024); 
         } 

         fclose($fp); // close connection

      }
	  
      if (strpos($this->ipn_response,"VERIFIED") !== false) {
  
         // Valid IPN transaction.
         $this->log_ipn_results(true);
         return true;       
         
      } else {
  
         // Invalid IPN transaction.  Check the log for details.
         $this->last_error = 'IPN Validation Failed.';
         $this->log_ipn_results(false);   
         return false;
         
      }
      
   }
// ipn login details
   function log_ipn_results($success) 
   {
      if (!$this->ipn_log) return;  // is logging turned off?
      $text = '['.date('m/d/Y g:i A').'] - '; // Timestamp 
      // Success or failure being logged?
      if ($success) $text.= "SUCCESS!\n";
      else $text.= 'FAIL: '.$this->last_error."\n";
      // Log the POST variables
      $text.= "IPN POST Vars from Paypal:\n";
      foreach ($this->ipn_data as $key=>$value) { $text.= "$key=$value, "; }
      // Log the response from the paypal server
      $text.= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
      $fp=fopen($this->ipn_log_file,'a'); fwrite($fp, $text. "\n\n"); fclose($fp);
	  return $text;
   }
// Used for debugging, this function will output all the field/value pairs defined  using add_field()
   function dump_fields()
   {
      $html_r = "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\"><tr>";
      $html_r.= "<td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>";
      $html_r.= "<td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td></tr>"; 
      ksort($this->fields);
      foreach ($this->fields as $key => $value) { $html_r.= "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>"; }
      $html_r.= "</table>"; 
	  return $html_r;
   }
// ipn log details
   function dump_ipn_results()
   {
      $html_r = "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\"><tr>";
      $html_r.= "<td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>";
      $html_r.= "<td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td></tr>"; 
      foreach ($this->ipn_data as $key=>$value) { $html_r.= "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>"; }
      $html_r.= "</table>"; 
	  return $html_r;
   }
}
$paypal		 = new paypal();         