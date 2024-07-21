<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!file_exists("vpn")) {
    mkdir("vpn", 511, true);
}
$db1 = new SQLite3("./api/data/.boxbr_vpn.db");
if (isset($_POST["submit"])) {
    $target_dir = "vpn/";
    $file_path = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/vpn/";
    if (empty($_POST["url"])) {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (file_exists($target_file)) {
            unlink($target_file);
            $msg = "The file already exists and has been replaced.";
        } else {
            $msg = "Success, OVPN File uploaded.";
        }
        $uploadOk = 1;
        if (500000 < $_FILES["fileToUpload"]["size"]) {
            $msg = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "ovpn") {
            $msg = "Sorry, only OVPN files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            header("Location: add_vpn.php?messageE=" . $msg);
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $vpn = "" . $file_path . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "";
                $vpn_name = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
                $db1->exec("INSERT INTO boxbrvpn(vpn_country, vpn_config, vpn_file_name) VALUES('" . $_POST["vpn_country"] . "', '" . $vpn . "', '" . $vpn_name . "')");
                $db1->close();
                header("Location: vpn.php?messageS=" . $msg);
            }
        }
    } else {
        $url = $_POST["url"];
        $target_file = $target_dir . basename($url);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (file_exists($target_file)) {
            unlink($target_file);
            $msgt = "1";
            $msg = "The file already exists and has been replaced.";
        } else {
            $msg = "Success, Url OVPN File saved.";
        }
        if ($imageFileType != "ovpn") {
            $msg = "Sorry, only OVPN files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            header("Location: add_vpn.php?messageE=" . $msg);
        } else {
            $vpn = "" . $file_path . htmlspecialchars(basename($url)) . "";
            $vpn_name = htmlspecialchars(basename($url));
            $file = fopen($url, "rb");
            if ($file) {
                $newf = fopen($target_file, "wb");
                if ($newf) {
                    while (!feof($file)) {
                        fwrite($newf, fread($file, 8192), 8192);
                    }
                }
            }
            if ($file) {
                fclose($file);
            }
            if ($newf) {
                fclose($newf);
            }
            if ($msgt) {
                header("Location: vpn.php?messageA=" . $msg);
            } else {
                header("Location: vpn.php?messageS=" . $msg);
                $db1->exec("INSERT INTO boxbrvpn(vpn_country, vpn_config, vpn_file_name) VALUES('" . $_POST["vpn_country"] . "', '" . $vpn . "', '" . $vpn_name . "')");
                $db1->close();
            }
        }
    }
}
include "includes/header.php";
echo "<!-- [ Main Content ] start -->\n    <div class=\"pcoded-main-container\">\n        <div class=\"pcoded-wrapper\">\n            <div class=\"pcoded-content\">\n                <div class=\"pcoded-inner-content\">\n                    <div class=\"main-body\">\n                        <div class=\"page-wrapper\">\n                            <!-- [ Main Content ] start -->\n                            <div class=\"row\">\n                    <!-- Column -->\n                    <div class=\"col-lg-12\">\n";
if (isset($_GET["messageE"])) {
    echo "<div class=\"alert alert-danger\" id=\"flash-msg\"><h4><i class=\"icon fa fa-times\"></i>" . $_GET["messageE"] . "</h4></div>";
}
echo "                        <div class=\"card mb-4\">\n\t\t\t\t\t\t\t<div class=\"card-header bg-primary py-3\">\n                \t\t\t\t<h4 align=\"center\" class=\"m-0 font-weight-bold text-white\"><i class=\"fas fa-user-secret\" style=\"font-size:20px\">&nbsp;&nbsp;</i>Virtual Private Network</h4>\n                \t\t\t</div>\n                         <div class=\"card-body\">\n                <form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n                            <form method=\"post\">\n                                <div class=\"form-group \">\n                                    <label class=\"control-label\" for=\"vpn_country\">\n                                        <strong>Country</strong>\n                                    </label>\n                                    <div class=\"input-group\">\n                                        <select class=\"select form-control text-primary\" id=\"select\" name=\"vpn_country\" required >\n\t\t\t\t\t\t\t\t\t    <option value=\"BR\">Brazil</option>\n\t\t\t\t\t\t\t\t\t    <option value=\"GB\">Great Britain</option>\n\t\t\t\t\t\t\t\t\t    <option value=\"US\">United States</option>\n<option value=\"AF\">Afghanistan</option>\n                <option value=\"AL\">Albania</option>\n                <option value=\"DZ\">Algeria</option>\n                <option value=\"AS\">American Samoa</option>\n                <option value=\"AD\">Andorra</option>\n                <option value=\"AO\">Angola</option>\n                <option value=\"AI\">Anguilla</option>\n                <option value=\"AQ\">Antarctica</option>\n                <option value=\"AG\">Antigua and Barbuda</option>\n                <option value=\"AR\">Argentina</option>\n                <option value=\"AM\">Armenia</option>\n                <option value=\"AW\">Aruba</option>\n                <option value=\"AU\">Australia</option>\n                <option value=\"AT\">Austria</option>\n                <option value=\"AZ\">Azerbaijan</option>\n                <option value=\"BS\">Bahamas</option>\n                <option value=\"BH\">Bahrain</option>\n                <option value=\"BD\">Bangladesh</option>\n                <option value=\"BB\">Barbados</option>\n                <option value=\"BY\">Belarus</option>\n                <option value=\"BE\">Belgium</option>\n                <option value=\"BZ\">Belize</option>\n                <option value=\"BJ\">Benin</option>\n                <option value=\"BM\">Bermuda</option>\n                <option value=\"BT\">Bhutan</option>\n                <option value=\"BO\">Bolivia</option>\n                <option value=\"BA\">Bosnia and Herzegovina</option>\n                <option value=\"BW\">Botswana</option>\n                <option value=\"BV\">Bouvet Island</option>\n                <option value=\"BQ\">British Indian Ocean Territory</option>\n                <option value=\"IO\">Brunei Darussalam</option>\n                <option value=\"BG\">Bulgaria</option>\n                <option value=\"BF\">Burkina Faso</option>\n\t<option value=\"BI\">Burundi</option>\n\t<option value=\"KH\">Cambodia</option>\n\t<option value=\"CM\">Cameroon</option>\n\t<option value=\"CA\">Canada</option>\n\t<option value=\"CV\">Cape Verde</option>\n\t<option value=\"KY\">Cayman Islands</option>\n\t<option value=\"CF\">Central African Republic</option>\n\t<option value=\"TD\">Chad</option>\n\t<option value=\"CL\">Chile</option>\n\t<option value=\"CN\">China</option>\n\t<option value=\"CX\">Christmas Island</option>\n\t<option value=\"CC\">Cocos (Keeling) Islands</option>\n\t<option value=\"CO\">Colombia</option>\n\t<option value=\"KM\">Comoros</option>\n\t<option value=\"CG\">Congo</option>\n\t<option value=\"CD\">Congo, the Democratic Republic of the</option>\n\t<option value=\"CK\">Cook Islands</option>\n\t<option value=\"CR\">Costa Rica</option>\n\t<option value=\"CI\">Côte d'Ivoire</option>\n\t<option value=\"HR\">Croatia</option>\n\t<option value=\"CU\">Cuba</option>\n\t<option value=\"CW\">Curaçao</option>\n\t<option value=\"CY\">Cyprus</option>\n\t<option value=\"CZ\">Czech Republic</option>\n\t<option value=\"DK\">Denmark</option>\n\t<option value=\"DJ\">Djibouti</option>\n\t<option value=\"DM\">Dominica</option>\n\t<option value=\"DO\">Dominican Republic</option>\n\t<option value=\"EC\">Ecuador</option>\n\t<option value=\"EG\">Egypt</option>\n\t<option value=\"SV\">El Salvador</option>\n\t<option value=\"GQ\">Equatorial Guinea</option>\n\t<option value=\"ER\">Eritrea</option>\n\t<option value=\"EE\">Estonia</option>\n\t<option value=\"ET\">Ethiopia</option>\n\t<option value=\"FK\">Falkland Islands (Malvinas)</option>\n\t<option value=\"FO\">Faroe Islands</option>\n\t<option value=\"FJ\">Fiji</option>\n\t<option value=\"FI\">Finland</option>\n\t<option value=\"FR\">France</option>\n\t<option value=\"GF\">French Guiana</option>\n\t<option value=\"PF\">French Polynesia</option>\n\t<option value=\"TF\">French Southern Territories</option>\n\t<option value=\"GA\">Gabon</option>\n\t<option value=\"GM\">Gambia</option>\n\t<option value=\"GE\">Georgia</option>\n\t<option value=\"DE\">Germany</option>\n\t<option value=\"GH\">Ghana</option>\n\t<option value=\"GI\">Gibraltar</option>\n\t<option value=\"GR\">Greece</option>\n\t<option value=\"GL\">Greenland</option>\n\t<option value=\"GD\">Grenada</option>\n\t<option value=\"GP\">Guadeloupe</option>\n\t<option value=\"GU\">Guam</option>\n\t<option value=\"GT\">Guatemala</option>\n\t<option value=\"GG\">Guernsey</option>\n\t<option value=\"GN\">Guinea</option>\n\t<option value=\"GW\">Guinea-Bissau</option>\n\t<option value=\"GY\">Guyana</option>\n\t<option value=\"HT\">Haiti</option>\n\t<option value=\"HM\">Heard Island and McDonald Islands</option>\n\t<option value=\"VA\">Holy See (Vatican City State)</option>\n\t<option value=\"HN\">Honduras</option>\n\t<option value=\"HK\">Hong Kong</option>\n\t<option value=\"HU\">Hungary</option>\n\t<option value=\"IS\">Iceland</option>\n\t<option value=\"IN\">India</option>\n\t<option value=\"ID\">Indonesia</option>\n\t<option value=\"IR\">Iran, Islamic Republic of</option>\n\t<option value=\"IQ\">Iraq</option>\n\t<option value=\"IE\">Ireland</option>\n\t<option value=\"IM\">Isle of Man</option>\n\t<option value=\"IL\">Israel</option>\n\t<option value=\"IT\">Italy</option>\n\t<option value=\"JM\">Jamaica</option>\n\t<option value=\"JP\">Japan</option>\n\t<option value=\"JE\">Jersey</option>\n\t<option value=\"JO\">Jordan</option>\n\t<option value=\"KZ\">Kazakhstan</option>\n\t<option value=\"KE\">Kenya</option>\n\t<option value=\"KI\">Kiribati</option>\n\t<option value=\"KP\">Korea, Democratic People's Republic of</option>\n\t<option value=\"KR\">Korea, Republic of</option>\n\t<option value=\"KW\">Kuwait</option>\n\t<option value=\"KG\">Kyrgyzstan</option>\n\t<option value=\"LA\">Lao People's Democratic Republic</option>\n\t<option value=\"LV\">Latvia</option>\n\t<option value=\"LB\">Lebanon</option>\n\t<option value=\"LS\">Lesotho</option>\n\t<option value=\"LR\">Liberia</option>\n\t<option value=\"LY\">Libya</option>\n\t<option value=\"LI\">Liechtenstein</option>\n\t<option value=\"LT\">Lithuania</option>\n\t<option value=\"LU\">Luxembourg</option>\n\t<option value=\"MO\">Macao</option>\n\t<option value=\"MK\">Macedonia, the former Yugoslav Republic of</option>\n\t<option value=\"MG\">Madagascar</option>\n\t<option value=\"MW\">Malawi</option>\n\t<option value=\"MY\">Malaysia</option>\n\t<option value=\"MV\">Maldives</option>\n\t<option value=\"ML\">Mali</option>\n\t<option value=\"MT\">Malta</option>\n\t<option value=\"MH\">Marshall Islands</option>\n\t<option value=\"MQ\">Martinique</option>\n\t<option value=\"MR\">Mauritania</option>\n\t<option value=\"MU\">Mauritius</option>\n\t<option value=\"YT\">Mayotte</option>\n\t<option value=\"MX\">Mexico</option>\n\t<option value=\"FM\">Micronesia, Federated States of</option>\n\t<option value=\"MD\">Moldova, Republic of</option>\n\t<option value=\"MC\">Monaco</option>\n\t<option value=\"MN\">Mongolia</option>\n\t<option value=\"ME\">Montenegro</option>\n\t<option value=\"MS\">Montserrat</option>\n\t<option value=\"MA\">Morocco</option>\n\t<option value=\"MZ\">Mozambique</option>\n\t<option value=\"MM\">Myanmar</option>\n\t<option value=\"NA\">Namibia</option>\n\t<option value=\"NR\">Nauru</option>\n\t<option value=\"NP\">Nepal</option>\n\t<option value=\"NL\">Netherlands</option>\n\t<option value=\"NC\">New Caledonia</option>\n\t<option value=\"NZ\">New Zealand</option>\n\t<option value=\"NI\">Nicaragua</option>\n\t<option value=\"NE\">Niger</option>\n\t<option value=\"NG\">Nigeria</option>\n\t<option value=\"NU\">Niue</option>\n\t<option value=\"NF\">Norfolk Island</option>\n\t<option value=\"MP\">Northern Mariana Islands</option>\n\t<option value=\"NO\">Norway</option>\n\t<option value=\"OM\">Oman</option>\n\t<option value=\"PK\">Pakistan</option>\n\t<option value=\"PW\">Palau</option>\n\t<option value=\"PS\">Palestinian Territory, Occupied</option>\n\t<option value=\"PA\">Panama</option>\n\t<option value=\"PG\">Papua New Guinea</option>\n\t<option value=\"PY\">Paraguay</option>\n\t<option value=\"PE\">Peru</option>\n\t<option value=\"PH\">Philippines</option>\n\t<option value=\"PN\">Pitcairn</option>\n\t<option value=\"PL\">Poland</option>\n\t<option value=\"PT\">Portugal</option>\n\t<option value=\"PR\">Puerto Rico</option>\n\t<option value=\"QA\">Qatar</option>\n\t<option value=\"RE\">Réunion</option>\n\t<option value=\"RO\">Romania</option>\n\t<option value=\"RU\">Russian Federation</option>\n\t<option value=\"RW\">Rwanda</option>\n\t<option value=\"BL\">Saint Barthélemy</option>\n\t<option value=\"SH\">Saint Helena, Ascension and Tristan da Cunha</option>\n\t<option value=\"KN\">Saint Kitts and Nevis</option>\n\t<option value=\"LC\">Saint Lucia</option>\n\t<option value=\"MF\">Saint Martin (French part)</option>\n\t<option value=\"PM\">Saint Pierre and Miquelon</option>\n\t<option value=\"VC\">Saint Vincent and the Grenadines</option>\n\t<option value=\"WS\">Samoa</option>\n\t<option value=\"SM\">San Marino</option>\n\t<option value=\"ST\">Sao Tome and Principe</option>\n\t<option value=\"SA\">Saudi Arabia</option>\n\t<option value=\"SN\">Senegal</option>\n\t<option value=\"RS\">Serbia</option>\n\t<option value=\"SC\">Seychelles</option>\n\t<option value=\"SL\">Sierra Leone</option>\n\t<option value=\"SG\">Singapore</option>\n\t<option value=\"SX\">Sint Maarten (Dutch part)</option>\n\t<option value=\"SK\">Slovakia</option>\n\t<option value=\"SI\">Slovenia</option>\n\t<option value=\"SB\">Solomon Islands</option>\n\t<option value=\"SO\">Somalia</option>\n\t<option value=\"ZA\">South Africa</option>\n\t<option value=\"GS\">South Georgia and the South Sandwich Islands</option>\n\t<option value=\"SS\">South Sudan</option>\n\t<option value=\"ES\">Spain</option>\n\t<option value=\"LK\">Sri Lanka</option>\n\t<option value=\"SD\">Sudan</option>\n\t<option value=\"SR\">Suriname</option>\n\t<option value=\"SJ\">Svalbard and Jan Mayen</option>\n\t<option value=\"SZ\">Swaziland</option>\n\t<option value=\"SE\">Sweden</option>\n\t<option value=\"CH\">Switzerland</option>\n\t<option value=\"SY\">Syrian Arab Republic</option>\n\t<option value=\"TW\">Taiwan, Province of China</option>\n\t<option value=\"TJ\">Tajikistan</option>\n\t<option value=\"TZ\">Tanzania, United Republic of</option>\n\t<option value=\"TH\">Thailand</option>\n\t<option value=\"TL\">Timor-Leste</option>\n\t<option value=\"TG\">Togo</option>\n\t<option value=\"TK\">Tokelau</option>\n\t<option value=\"TO\">Tonga</option>\n\t<option value=\"TT\">Trinidad and Tobago</option>\n\t<option value=\"TN\">Tunisia</option>\n\t<option value=\"TR\">Turkey</option>\n\t<option value=\"TM\">Turkmenistan</option>\n\t<option value=\"TC\">Turks and Caicos Islands</option>\n\t<option value=\"TV\">Tuvalu</option>\n\t<option value=\"UG\">Uganda</option>\n\t<option value=\"UA\">Ukraine</option>\n\t<option value=\"AE\">United Arab Emirates</option>\n\t<option value=\"UM\">United States Minor Outlying Islands</option>\n\t<option value=\"UY\">Uruguay</option>\n\t<option value=\"UZ\">Uzbekistan</option>\n\t<option value=\"VU\">Vanuatu</option>\n\t<option value=\"VE\">Venezuela, Bolivarian Republic of</option>\n\t<option value=\"VN\">Viet Nam</option>\n\t<option value=\"VG\">Virgin Islands, British</option>\n\t<option value=\"VI\">Virgin Islands, U.S.</option>\n\t<option value=\"WF\">Wallis and Futuna</option>\n\t<option value=\"EH\">Western Sahara</option>\n\t<option value=\"YE\">Yemen</option>\n\t<option value=\"ZM\">Zambia</option>\n\t<option value=\"ZW\">Zimbabwe</option>\n                                    </select>\n                                    </div>\n                                </div>\n\n                                <div class=\"form-group \">\n                                    <label class=\"control-label \" for=\"vpn_config\">\n                                        <strong>Select OVPN Type</strong>\n                                    </label>\n                                    <div class=\"input-group\">\n\t\t\t\t\t\t\t\t\t  <select class=\"form-control type\" id=\"type\" name=\"type\">\n\t\t\t\t\t\t\t\t\t\t  <option data-value=\"op0\" value=\"0\" ";
echo $rowU["type"] == "0" ? "selected" : "";
echo ">Upload OVPN File\n\t\t\t\t\t\t\t\t\t\t  </option>\n\t\t\t\t\t\t\t\t\t\t  <option data-value=\"op1\" value=\"1\" ";
echo $rowU["type"] == "1" ? "selected" : "";
echo ">Enter External URL\n\t\t\t\t\t\t\t\t\t\t  </option>\n\t\t\t\t\t\t\t\t\t  </select>\n                                    </div>\n                                </div>\n                                <div class=\"activeu\">\n                                <div class=\"form-group \">\n                                <label class=\"control-label\">Enter OVPN External URL</label>\n                                <div class=\"input-group\">\n                                <input  class=\"form-control\" type=\"text\" name=\"url\" placeholder=\"Enter URL file.ovpn\">\n                                </div>\n                                 </div>\n                                </div>\n                         <div class=\"actived\">\n                           <div class=\"form-group \">\n                                    <label class=\"control-label \" for=\"vpn_config\">\n                                        <strong>OVPN File</strong>\n                                    </label>\n                                    <div class=\"input-group\">\n \n     <div class=\"custom-file\">\n<input class=\"custom-file-input\" type=\"file\" class=\"form-control text-primary\" name=\"fileToUpload\" id=\"fileToUpload\" >\n\n    <label class=\"custom-file-label\" for=\"fileToUpload\" placeholder=\"Choose OVPN File\"><span id=\"OVPN\">Choose OVPN File</span></label>\n  </div>\n\n\n                                    </div>\n                                </div>\n\t\t\t\t\t\t\t\t</div>\n                                <div class=\"form-group\">\n                                    <div>\n                                        <button class=\"btn btn-success btn-icon-split\" name=\"submit\" type=\"submit\">\n                        <span class=\"icon text-white-50\"><i class=\"fas fa-check\"></i></span><span class=\"text\">Submit</span>\n                        </button>\n                                    </div>\n                                </div>\n                            </form>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n    <br><br><br>\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>\n    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js\"></script>\n    <script>\n//select activecode form\n//var response = {};\n//response.val = \"op2\";\n//\$(\"#codemode option[data-value='\" + response.val +\"']\").attr(\"selected\",\"selected\");\n\n//hide activecode form\n\$('.actived').show(); \n\n\$('.activeu').hide(); \n\n\n//Show/hide activecode select\n\$(document).ready(function(){\n  \$('.type').change(function(){\n    if(\$('.type').val() > 0) {\n      \$('.actived').hide(); \n      \$('.activeu').show(); \n    } else {\n      \$('.activeu').hide(); \n      \$('.actived').show(); \n     document.getElementById(\"activeu\").value = ' ';\n    } \n  });\n  \$('.type').ready(function(){\n    if(\$('.type').val() > 0) {\n      \$('.actived').hide(); \n      \$('.activeu').show(); \n    }else {\n      \$('.activeu').hide(); \n      \$('.actived').show(); \n     document.getElementById(\"actived\").value = ' ';\n      \n    } \n  });\n});\n</script>\n";
include "includes/functions.php";
echo "?>";

?>