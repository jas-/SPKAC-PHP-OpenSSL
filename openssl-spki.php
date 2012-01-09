<?php

@date_default_timezone_set(@date_default_timezone_get());

$settings['opts'] = array('digest_alg'       => 'sha1',
                          'private_key_type' => OPENSSL_KEYTYPE_RSA,
                          'private_key_bits' => 2048);

$settings['dn'] = array('commonName'             => 'Jas-',
                        'emailAddress'           => 'jason.gerfen@gmail.com',
                        'countryName'            => 'US',
                        'stateOrProvinceName'    => 'Utah',
                        'localityName'           => 'Roy',
                        'organizationName'       => 'University Of Utah',
                        'organizationalUnitName' => 'Marriott Library');

if (!empty($_POST['spki-key'])){

 if ((!empty($_POST['commonName']))&&
     (!empty($_POST['emailAddress']))&&
     (!empty($_POST['countryName']))&&
     (!empty($_POST['stateOrProvinceName']))&&
     (!empty($_POST['localityName']))&&
     (!empty($_POST['organizationName']))&&
     (!empty($_POST['organizationalUnitName']))){

  $settings['dn']['countryName'] = $_POST['countryName'];
  $settings['dn']['stateOrProvinceName'] = $_POST['stateOrProvinceName'];
  $settings['dn']['localityName'] = $_POST['localityName'];
  $settings['dn']['organizationName'] = $_POST['organizationName'];
  $settings['dn']['organizationalUnitName'] = $_POST['organizationalUnitName'];
  $settings['dn']['commonName'] = $_POST['commonName'];
  $settings['dn']['emailAddress'] = $_POST['emailAddress'];
  $settings['dn']['SPKAC'] = $_POST['spki-key'];

  $key = openssl_pkey_new($settings['opts']);

  if (!empty($_POST['spki-key'])){
   if (function_exists('openssl_spki_export_challenge')){
    $pwd = openssl_spki_export_challenge($_POST['spki-key']);
   }
   if (function_exists('openssl_spki_export')){
    $pkey = openssl_spki_export($_POST['spki-key']);
   }
   openssl_pkey_export($key, $pkey, $pwd);
  }

  $a = openssl_pkey_get_private($pkey, $pwd);

  $b = openssl_csr_new($settings['dn'], $a, $settings['opts']);

  openssl_csr_export($b, $c);

  $d = openssl_csr_sign($c, NULL, $a, 365);
  //$c = openssl_spki_export_cert($a, $_POST['spki-key'], $settings['dn'], $settings['opts']);

  //openssl_csr_export($c, $d);

echo '<pre>'; print_r($c); echo '</pre>';
/*
  $length = sizeof($d);
  header('Last-Modified: '.date('r+b'));
  header('Accept-Ranges: bytes');
  header('Content-Length: '.$length);
  header('Content-Type: application/x-x509-user-cert');
  readfile('/tmp/'.$_POST['emailAddress'].'-cert');
  exit;
*/
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>PHP OpenSSL SPKI functionality</title>
 <link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
</head>
<body>
<div id="contact-form" class="clearfix">
 <h2>SPKAC to PKCS#7 certificate generator</h2>
 <p>This form is to demo the HTML5 KeyGen tag and the new PHP OpenSSL SPKI family of functions</p>
 <form id="spkac" name="spkac" method="post" action="openssl-spki.php">
  <div>
   <label for="emailAddress">Email:</label>
    <input type="email" name="emailAddress">
  </div>
  <div>
   <label for="commonName">Name:</label>
    <input type="text" name="commonName">
  </div>
  <div>
   <label for="countryName">Country:</label>
    <select name="countryName">
     <optgroup label="North America">
      <option value="US">United States</option>
      <option value="AI">Anguilla</option>
      <option value="AG">Antigua and Barbuda</option>
      <option value="ABC">Aruba</option>
      <option value="BS">Bahamas</option>
      <option value="BB">Barbados</option>
      <option value="BZ">Belize</option>
      <option value="BM">Bermuda</option>
      <option value="VG">Virgin Islands, British</option>
      <option value="CA">Canada</option>
      <option value="KY">Cayman Islands</option>
      <option value="CR">Costa Rica</option>
      <option value="CU">Cuba</option>
      <option value="DM">Dominica</option>
      <option value="DO">Dominican Republic</option>
      <option value="SV">El Salvador</option>
      <option value="FK">Falkland Islands (Malvinas)</option>
      <option value="GL">Greenland</option>
      <option value="GD">Grenada</option>
      <option value="GP">Guadeloupe</option>
      <option value="GT">Guatemala</option>
      <option value="HT">Haiti</option>
      <option value="HN">Honduras</option>
      <option value="JM">Jamaica</option>
      <option value="MQ">Martinique</option>
      <option value="MX">Mexico</option>
      <option value="MS">Montserrat</option>
      <option value="AN">Netherlands Antilles</option>
      <option value="NI">Nicaragua</option>
      <option value="PA">Panama</option>
      <option value="PR">Puerto Rico</option>
      <option value="KN">Saint Kitts and Nevis</option>
      <option value="LC">Saint Lucia</option>
      <option value="PM">Saint Pierre and Miquelon</option>
      <option value="VC">Saint Vincent and The Grenadines</option>
      <option value="TT">Trinidad and Tobago</option>
      <option value="TC">Turks and Caicos Islands</option>
      <option value="UM">United States Minor Outlying Islands</option>
      <option value="VI">Virgin Islands, U.S.</option>
     </optgroup>
     <optgroup label="South America">
      <option value="010">Argentina</option>
      <option value="026">Bolivia</option>
      <option value="030">Brazil</option>
      <option value="043">Chile</option>
      <option value="047">Colombia</option>
      <option value="062">Ecuador</option>
      <option value="074">French Guiana</option>
      <option value="091">Guyana</option>
      <option value="167">Paraguay</option>
      <option value="168">Peru</option>
      <option value="202">Suriname</option>
      <option value="228">Uruguay</option>
      <option value="231">Venezuela</option>
     </optgroup>
     <optgroup label="Antarctica">
      <option value="008">Antarctica</option>
      <option value="029">Bouvet Island</option>
      <option value="076">French Southern Territories</option>
      <option value="093">Heard Island and Mcdonald Islands</option>
      <option value="198">South Georgia and The South Sandwich Islands</option>
     </optgroup>
     <optgroup label="Africa">
      <option value="003">Algeria</option>
      <option value="006">Angola</option>
      <option value="023">Benin</option>
      <option value="028">Botswana</option>
      <option value="034">Burkina Faso</option>
      <option value="035">Burundi</option>
      <option value="037">Cameroon</option>
      <option value="039">Cape Verde</option>
      <option value="041">Central African Republic</option>
      <option value="042">Chad</option>
      <option value="048">Comoros</option>
      <option value="049">Congo</option>
      <option value="050">Congo, The Democratic Republic of The</option>
      <option value="053">Cote D'ivoire</option>
      <option value="059">Djibouti</option>
      <option value="063">Egypt</option>
      <option value="065">Equatorial Guinea</option>
      <option value="066">Eritrea</option>
      <option value="068">Ethiopia</option>
      <option value="077">Gabon</option>
      <option value="078">Gambia</option>
      <option value="081">Ghana</option>
      <option value="089">Guinea</option>
      <option value="090">Guinea-bissau</option>
      <option value="110">Kenya</option>
      <option value="119">Lesotho</option>
      <option value="120">Liberia</option>
      <option value="121">Libyan Arab Jamahiriya</option>
      <option value="235">Wallis and Futuna</option>
      <option value="236">Western Sahara</option>
      <option value="237">Yemen</option>
      <option value="127">Madagascar</option>
      <option value="128">Malawi</option>
      <option value="131">Mali</option>
      <option value="135">Mauritania</option>
      <option value="136">Mauritius</option>
      <option value="137">Mayotte</option>
      <option value="144">Morocco</option>
      <option value="145">Mozambique</option>
      <option value="147">Namibia</option>
      <option value="155">Niger</option>
      <option value="156">Nigeria</option>
      <option value="175">Reunion</option>
      <option value="178">Rwanda</option>
      <option value="179">Saint Helena</option>
      <option value="186">Sao Tome and Principe</option>
      <option value="188">Senegal</option>
      <option value="190">Seychelles</option>
      <option value="191">Sierra Leone</option>
      <option value="196">Somalia</option>
      <option value="197">South Africa</option>
      <option value="201">Sudan</option>
      <option value="204">Swaziland</option>
      <option value="210">Tanzania, United Republic of</option>
      <option value="213">Togo</option>
      <option value="217">Tunisia</option>
      <option value="222">Uganda</option>
      <option value="238">Zambia</option>
      <option value="239">Zimbabwe</option>
     </optgroup>
     <optgroup label="Europe">
      <option value="002">Albania</option>
      <option value="005">Andorra</option>
      <option value="011">Armenia</option>
      <option value="014">Austria</option>
      <option value="015">Azerbaijan</option>
      <option value="020">Belarus</option>
      <option value="021">Belgium</option>
      <option value="027">Bosnia and Herzegovina</option>
      <option value="033">Bulgaria</option>
      <option value="054">Croatia</option>
      <option value="056">Cyprus</option>
      <option value="057">Czech Republic</option>
      <option value="058">Denmark</option>
      <option value="067">Estonia</option>
      <option value="070">Faroe Islands</option>
      <option value="072">Finland</option>
      <option value="073">France</option>
      <option value="079">Georgia</option>
      <option value="080">Germany</option>
      <option value="082">Gibraltar</option>
      <option value="083">Greece</option>
      <option value="084">Greenland</option>
      <option value="097">Hungary</option>
      <option value="098">Iceland</option>
      <option value="103">Ireland</option>
      <option value="105">Italy</option>
      <option value="109">Kazakhstan</option>
      <option value="300">Kosovo</option>
      <option value="117">Latvia</option>
      <option value="122">Liechtenstein</option>
      <option value="123">Lithuania</option>
      <option value="124">Luxembourg</option>
      <option value="126">Macedonia</option>
      <option value="132">Malta</option>
      <option value="140">Moldova, Republic of</option>
      <option value="141">Monaco</option>
      <option value="301">Montenegro</option>
      <option value="150">Netherlands</option>
      <option value="160">Norway</option>
      <option value="171">Poland</option>
      <option value="172">Portugal</option>
      <option value="176">Romania</option>
      <option value="177">Russia</option>
      <option value="185">San Marino</option>
      <option value="189">Serbia and Montenegro</option>
      <option value="193">Slovakia</option>
      <option value="194">Slovenia</option>
      <option value="199">Spain</option>
      <option value="203">Svalbard and Jan Mayen</option>
      <option value="205">Sweden</option>
      <option value="206">Switzerland</option>
      <option value="218">Turkey</option>
      <option value="223">Ukraine</option>
      <option value="225">United Kingdom</option>
      <option value="094">Vatican City</option>
     </optgroup>
     <optgroup label="Asia">
      <option value="001">Afghanistan</option>
      <option value="011">Armenia</option>
      <option value="015">Azerbaijan</option>
      <option value="017">Bahrain</option>
      <option value="018">Bangladesh</option>
      <option value="025">Bhutan</option>
      <option value="031">British Indian Ocean Territory</option>
      <option value="032">Brunei Darussalam</option>
      <option value="036">Cambodia</option>
      <option value="044">China</option>
      <option value="056">Cyprus</option>
      <option value="079">Georgia</option>
      <option value="096">Hong Kong</option>
      <option value="099">India</option>
      <option value="100">Indonesia</option>
      <option value="101">Iran</option>
      <option value="102">Iraq</option>
      <option value="104">Israel</option>
      <option value="107">Japan</option>
      <option value="108">Jordan</option>
      <option value="109">Kazakhstan</option>
      <option value="112">Korea, North</option>
      <option value="113">Korea, South</option>
      <option value="114">Kuwait</option>
      <option value="115">Kyrgyzstan</option>
      <option value="116">Laos</option>
      <option value="118">Lebanon</option>
      <option value="125">Macau</option>
      <option value="129">Malaysia</option>
      <option value="130">Maldives</option>
      <option value="142">Mongolia</option>
      <option value="146">Myanmar</option>
      <option value="149">Nepal</option>
      <option value="161">Oman</option>
      <option value="162">Pakistan</option>
      <option value="164">Palestinian Territory</option>
      <option value="169">Philippines</option>
      <option value="174">Qatar</option>
      <option value="177">Russia</option>
      <option value="187">Saudi Arabia</option>
      <option value="192">Singapore</option>
      <option value="200">Sri Lanka</option>
      <option value="207">Syria</option>
      <option value="208">Taiwan</option>
      <option value="209">Tajikistan</option>
      <option value="211">Thailand</option>
      <option value="212">Timor-leste</option>
      <option value="218">Turkey</option>
      <option value="219">Turkmenistan</option>
      <option value="224">United Arab Emirates</option>
      <option value="229">Uzbekistan</option>
      <option value="232">Vietnam</option>
      <option value="237">Yemen</option>
     </optgroup>
     <optgroup label="Oceania">
      <option value="004">American Samoa</option>
      <option value="013">Australia</option>
      <option value="045">Christmas Island</option>
      <option value="046">Cocos (Keeling) Islands</option>
      <option value="051">Cook Islands</option>
      <option value="302">Easter Island</option>
      <option value="071">Fiji</option>
      <option value="087">Guam</option>
      <option value="100">Indonesia</option>
      <option value="111">Kiribati</option>
      <option value="133">Marshall Islands</option>
      <option value="139">Micronesia, Federated States of</option>
      <option value="148">Nauru</option>
      <option value="152">New Caledonia</option>
      <option value="153">New Zealand</option>
      <option value="157">Niue</option>
      <option value="158">Norfolk Island</option>
      <option value="159">Northern Mariana Islands</option>
      <option value="163">Palau</option>
      <option value="166">Papua New Guinea</option>
      <option value="170">Pitcairn</option>
      <option value="075">French Polynesia</option>
      <option value="184">Samoa</option>
      <option value="195">Solomon Islands</option>
      <option value="214">Tokelau</option>
      <option value="215">Tonga</option>
      <option value="221">Tuvalu</option>
      <option value="230">Vanuatu</option>
     </optgroup>
    </select>
  </div>
  <div>
   <label for="stateOrProvinceName">State:</label>
    <select name="stateOrProvinceName">
     <option value="AL">Alabama</option>
     <option value="AK">Alaska</option>
     <option value="AZ">Arizona</option>
     <option value="AR">Arkansas</option>
     <option value="CA">California</option>
     <option value="CO">Colorado</option>
     <option value="CT">Connecticut</option>
     <option value="DE">Delaware</option>
     <option value="DC">District Of Columbia</option>
     <option value="FL">Florida</option>
     <option value="GA">Georgia</option>
     <option value="HI">Hawaii</option>
     <option value="ID">Idaho</option>
     <option value="IL">Illinois</option>
     <option value="IN">Indiana</option>
     <option value="IA">Iowa</option>
     <option value="KS">Kansas</option>
     <option value="KY">Kentucky</option>
     <option value="LA">Louisiana</option>
     <option value="ME">Maine</option>
     <option value="MD">Maryland</option>
     <option value="MA">Massachusetts</option>
     <option value="MI">Michigan</option>
     <option value="MN">Minnesota</option>
     <option value="MS">Mississippi</option>
     <option value="MO">Missouri</option>
     <option value="MT">Montana</option>
     <option value="NE">Nebraska</option>
     <option value="NV">Nevada</option>
     <option value="NH">New Hampshire</option>
     <option value="NJ">New Jersey</option>
     <option value="NM">New Mexico</option>
     <option value="NY">New York</option>
     <option value="NC">North Carolina</option>
     <option value="ND">North Dakota</option>
     <option value="OH">Ohio</option>
     <option value="OK">Oklahoma</option>
     <option value="OR">Oregon</option>
     <option value="PA">Pennsylvania</option>
     <option value="RI">Rhode Island</option>
     <option value="SC">South Carolina</option>
     <option value="SD">South Dakota</option>
     <option value="TN">Tennessee</option>
     <option value="TX">Texas</option>
     <option value="UT">Utah</option>
     <option value="VT">Vermont</option>
     <option value="VA">Virginia</option>
     <option value="WA">Washington</option>
     <option value="WV">West Virginia</option>
     <option value="WI">Wisconsin</option>
     <option value="WY">Wyoming</option>
    </select>
  </div>
  <div>
   <label for="localityName">City:</label>
    <input type="text" name="localityName">
  </div>
  <div>
   <label for="organizationalName">Organization:</label>
    <input type="text" name="organizationName">
  </div>
  <div>
   <label for="organizationalUnitName">Department:</label>
    <input type="text" name="organizationalUnitName">
  </div>
  <div>
  <label for="spki-key">Key strength:</label>
   <keygen name="spki-key" keytype="rsa" challenge="testing"></keygen>
  </div>
  <input type="submit">
 </form>
</div>
<div id="contact-form" class="clearfix" style="word-wrap:break-word; font-size: 12px">
<?php
if (empty($_POST['spki-key'])){
 echo "Generating private key...";
 $key = openssl_pkey_new(array('digest_alg' => 'sha512',
                               'private_key_type' => OPENSSL_KEYTYPE_RSA,
                               'private_key_bits' => 2048));
 echo "done<br/>";
 echo "============================<br/>";
}

if (empty($_POST['spki-key'])){
 echo "Creating SPKAC...<br/>";
 if (function_exists('openssl_spki_new')){
  $spki = openssl_spki_new($key, 'wtfd00d', 'sha512');
  echo $spki;
 }
 echo "<br/>done<br/>";
 echo "============================<br/>";
}

if (!empty($_POST['spki-key'])){
 echo "Recieved SPKAC...<br/>";
 echo $_POST['spki-key']."<br/>";
 echo "done<br/>";
 echo "============================<br/>";
}

echo "Verifying SPKAC...<br/>";
if (function_exists('openssl_spki_verify')){
 $y = (empty($_POST['spki-key'])) ?
  openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki)) :
  openssl_spki_verify($_POST['spki-key']);
 var_dump($y);
}
echo "<br/>============================<br/>";

echo "Exporting challenge from SPKAC...<br/>";
if (function_exists('openssl_spki_export_challenge')){
 $x = (empty($_POST['spki-key'])) ?
  openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki)) :
  openssl_spki_export_challenge($_POST['spki-key']);
 echo $x;
}
echo "<br/>done<br/>";
echo "============================<br/>";

echo "Exporting public key from SPKAC...<br/>";
if (function_exists('openssl_spki_export')){
 $z = (empty($_POST['spki-key'])) ?
  openssl_spki_export(preg_replace('/SPKAC=/', '', $spki)) :
  openssl_spki_export($_POST['spki-key']);
 echo '<pre>'; print_r($z); echo '</pre>';
}
echo "<br/>============================<br/>";

echo "SPKAC details...<br/>";
if (function_exists('openssl_spki_details')){
 $w = (empty($_POST['spki-key'])) ?
  openssl_spki_details(preg_replace('/SPKAC=/', '', $spki)) :
  openssl_spki_details($_POST['spki-key']);
 echo '<pre>'; print_r($w); echo '</pre>';
}
echo "done<br/>";
echo "============================<br/>";

if (empty($_POST['spki-key'])){
 openssl_free_key($key);
}
?>
</div>
</body>
