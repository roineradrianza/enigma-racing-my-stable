<?php 
session_start(); 
require '../vendor/autoload.php';
require_once "../model/Member.php";
require_once "../model/Syndicate_details.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$member=new Member();
$syndicateDetails = new Syndicate_Details();

$memberID=isset($_POST["memberID"])? cleanString($_POST["memberID"]):"";
$name=isset($_POST["fullname"])? cleanString($_POST["fullname"]):"";
$email=isset($_POST["email"])? cleanString($_POST["email"]):"";
$position=isset($_POST["position"])? cleanString($_POST["position"]):"member";
$password=isset($_POST["password"])? cleanString($_POST["password"]):"";
$resetCode=isset($_POST["resetCode"])? cleanString($_POST["resetCode"]):"";

switch ($_GET['op']) {
		case 'register':
			$passwordHash=hash("MD5",$password);
			$response=$member->register($name,$email,$passwordHash);
			if ($response >= 1) {
				$memberID = $response;
				$res = $member->show($memberID);
				$fetch = (array) $res;
				// send verification email
				$mail = new PHPMailer;
			    //Server settings
			    $mail->isSMTP();                                            // Send using SMTP
			    $mail->Host       = EMAIL_HOST;                    // Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = EMAIL_ACCOUNT;                     // SMTP username
			    $mail->Password   = EMAIL_PASSWORD;                               // SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption;
			    $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			    //Recipients
			    $mail->setFrom(EMAIL_ACCOUNT, 'Enigma Racing');
			    $mail->SMTPAuth = true;
			    $adminEmails = $member->list_admin_emails();
			    while ($reg = $adminEmails->fetch_object()) {
			    	$mail->addAddress($reg->email);
			    }

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'Enigma Racing - Member Verification';
			    $mail->Body    = "
			      <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
						    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;'>
						      <tr>
						        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
						        <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;''>
						          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

						            <!-- START CENTERED WHITE CONTAINER -->
						            <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;''>".$fetch['fullname']." is pending for verification.</span>
						            <table class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;''>

						              <!-- START MAIN CONTENT AREA -->
						              <tr>
						                <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
						                  <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
						                    <tr>
						                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>New member:</p>
																		<p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'><b>".$fetch['fullname']."</b> has registered for MyStable with email address: <b>".$fetch['email']."</b>. This member is now pending administrator approval.</p>
						                        <table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;'>
						                          <tbody>
						                            <tr>
						                              <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;'>
						                                <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;'>
						                                  <tbody>
						                                    <tr>
						                                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #6180A2; border-radius: 5px; text-align: center;'> <a href='".$_SERVER['SERVER_NAME']."/enigmaracing/verify.php?member=".$fetch['memberID']."' target='_blank' style='display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'> Verify user</a> </td>
						                                    </tr>
						                                  </tbody>
						                                </table>
						                              </td>
						                            </tr>
						                          </tbody>
						                        </table>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Alternatively, click this link <a href='".$_SERVER['SERVER_NAME']."/egnimaracing/verify.php?member=".$fetch['memberID']."'>Recover Password</a></p>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>ENIGMA MyStable</p>
						                      </td>
						                    </tr>
						                  </table>
						                </td>
						              </tr>

						            <!-- END MAIN CONTENT AREA -->
						            </table>

						          <!-- END CENTERED WHITE CONTAINER -->
						          </div>
						        </td>
						        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
						      </tr>
						    </table>
						  </body>
					";
					if (!$mail->send()) {
					    echo 'Mailer Error: '. $mail->ErrorInfo;
					} 
					else {
						// send to the new user a email message to remind it that is in a verification process
						$mail = new PHPMailer;
					    //Server settings
					    $mail->isSMTP(); // Send using SMTP
					    $mail->Host       = EMAIL_HOST; // Set the SMTP server to send through
					    $mail->SMTPAuth   = true;// Enable SMTP authentication
					    $mail->Username   = EMAIL_ACCOUNT;                     // SMTP username
					    $mail->Password   = EMAIL_PASSWORD; // SMTP password
					    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption;
					    $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

					    //Recipients
					    $mail->setFrom(EMAIL_ACCOUNT, 'Enigma Racing');
					    $mail->SMTPAuth = true;
							$mail->addAddress($fetch['email']);

					    // Content
					    $mail->isHTML(true); // Set email format to HTML
					    $mail->Subject = 'Enigma MyStable - Application pending';
					    $mail->Body    = "
					      <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
								    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;'>
								      <tr>
								        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
								        <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;''>
								          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

								            <!-- START CENTERED WHITE CONTAINER -->
								            <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;''>Hello, ".$fetch['fullname']." at this moment you are in a verification process.</span>
								            <table class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;''>

								              <!-- START MAIN CONTENT AREA -->
								              <tr>
								                <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
								                  <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
								                    <tr>
								                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>
								                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Thank you for your application</p>
								                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Your login access to ENIGMA MyStable is with the administrator, pending approval.</p>  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>We will be in touch by email as soon as your account is ready to use.</p>
								                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Kind regards, <br> Herbie<p/>
								                        <table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;'> <tbody> <tr>
								                              <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;'>
								                                <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;'>
								                                  <tbody>
								                                    <tr>
								                                  </tbody>
								                                </table>
								                              </td>
								                            </tr>
								                          </tbody></table> </td> </tr>
								                  </table>
								                </td>
								              </tr>

								            <!-- END MAIN CONTENT AREA -->
								            </table>

								          <!-- END CENTERED WHITE CONTAINER -->
								          </div>
								        </td>
								        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
								      </tr>
								    </table>
								  </body>
							";
							if ($mail->send()) {
								$message = [
									"title" => "Application submitted for approval",
							    "message" => "You will receive an email confirming when your login is ready to use, IMPORTANT: If no reply received in 2 hours, please check spam folder.",
							    "status" => true
								];
							}
							else{
								$message = [
									"title" => "Email not sent",
							    "message" => "Has not be possible to sent the email",
							    "status" => false
								];
							}
				    echo json_encode($message);
					}
			}
			else{
				$message = [
						"title" => "Registering no processed",
				    "message" => "An email has been already registered, try again",
				    "status" => false
				];
		    echo json_encode($message);
			}
		break;
		case 'verifyMember':
			$response = $member->verify_user($memberID);
			if ($response) {
				$res = $member->show($memberID);
				$fetch = (array) $res;
				// send verification email
				$mail = new PHPMailer;
			    //Server settings
			    $mail->isSMTP();                                            // Send using SMTP
			    $mail->Host       = EMAIL_HOST;                    // Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = EMAIL_ACCOUNT;                     // SMTP username
			    $mail->Password   = EMAIL_PASSWORD;                               // SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption;
			    $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			    //Recipients
			    $mail->setFrom(EMAIL_ACCOUNT, 'Enigma Racing');
			    $mail->SMTPAuth = true;
			    $mail->addAddress($fetch['emailRegistered']);     // Add a recipient

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'Enigma MyStable - Login approved';
			    $mail->Body    = "
			      <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
						    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;'>
						      <tr>
						        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
						        <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;''>
						          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

						            <!-- START CENTERED WHITE CONTAINER -->
						            <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;''>".$fetch['fullname'].", your verification is approved!.</span>
						            <table class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;''>

						              <!-- START MAIN CONTENT AREA -->
						              <tr>
						                <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
						                  <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
						                    <tr>
						                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Greetings!</p>
 						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'><b>".$fetch['fullname'].",</b> your access has been <b>approved</b> for email address:<p>".$fetch['email']."</p> 
						                        	<p>This is the email address linked to your syndicate shares and the one you need to use for MyStable login. You can update to a different email address anytime, just email: herbie@enigmaracing.net.</p>
																			<p>You can now login to see your stable</p>
						                        <table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;'>
						                          <tbody>
						                            <tr>
						                              <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;'>
						                                <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;'>
						                                  <tbody>
						                                    <tr>
						                                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #6180A2; border-radius: 5px; text-align: center;'> <a href='".$_SERVER['SERVER_NAME']."/enigmaracing/login.php' target='_blank' style='display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'> Sign In</a> </td>
						                                    </tr>
						                                  </tbody>
						                                </table>
						                              </td>
						                            </tr>
						                          </tbody>
						                        </table>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Alternatively, click this link <a href='".$_SERVER['SERVER_NAME']."/enigmaracing/login.php'>Sign in</a></p>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'></p>
						                      </td>
						                    </tr>
						                  </table>
						                </td>
						              </tr>

						            <!-- END MAIN CONTENT AREA -->
						            </table>

						          <!-- END CENTERED WHITE CONTAINER -->
						          </div>
						        </td>
						        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
						      </tr>
						    </table>
						  </body>
					";
					if (!$mail->send()) {
					    echo 'Mailer Error: '. $mail->ErrorInfo;
						$message = [
								"title" => "Verification unsucessful",
						    "message" => "The member can't be approved",
						    "status" => false
						];
					} 
					else {
						$message = [
								"title" => "Verification successfully",
						    "message" => $fetch['fullname']." has been approved for access and notified by email",
						    "status" => true
						];
				    echo json_encode($message);
					}
			}
		break;
		case 'saveAndEdit':
			if (isset($_SESSION['position']) AND $_SESSION['position'] === "admin") {
			if (empty($memberID)) {
				$passwordHash=hash("MD5",$password);
				$response=$member->create_member($name,$email,$passwordHash,$position);
				echo $response ? "Member created" : "It can't be possible create the member";
			}
			else{
					if ($password !== "") {
						$passwordHash=hash("MD5",$password);
						$response=$member->edit_P($memberID,$name,$email,$passwordHash,$position);
						echo $response ? "Member updated" : "It can't be possible update the member";	
					}
					else{
					$response=$member->edit($memberID,$name,$email,$position);
					echo $response ? "Member updated" : "It can't be possible update the member";	
					}
				}
			}
		break;
		case 'changePassword':
			$memberID = $_SESSION['userID'];
			$name = $_SESSION['name'];
			$position = $_SESSION['position'];
			$email = $_SESSION['email'];
			$passwordHash=hash("MD5",$password);
			$response=$member->edit_P($memberID,$name,$email,$passwordHash,$position);
				echo $response ? "Profile updated succesfully" : "It can't be possible update your profile";
		break;
		case 'resetPasswordRequest':
			$input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $input_length = strlen($input);
	    $random_string = '';
	    for($i = 0; $i < 16; $i++) {
	        $random_character = $input[mt_rand(0, $input_length - 1)];
	        $random_string .= $random_character;
	   }
			$code = $random_string . date("Ymd");
			$response = 	$member->resetPasswordRequest($email,$code);
			if ($response) {
			$mail = new PHPMailer;
				    //Server settings
				    $mail->isSMTP();                                            // Send using SMTP
				    $mail->Host       = EMAIL_HOST;                    // Set the SMTP server to send through
				    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				    $mail->Username   = EMAIL_ACCOUNT;                     // SMTP username
				    $mail->Password   = EMAIL_PASSWORD;                               // SMTP password
				    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption;
				    $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

				    //Recipients
				    $mail->setFrom(EMAIL_ACCOUNT, 'Enigma Racing');
				    $mail->SMTPAuth = true;
				    $mail->addAddress($email);     // Add a recipient

				    // Content
				    $mail->isHTML(true);                                  // Set email format to HTML
				    $mail->Subject = 'Enigma Racing - Password Reset';
				    $mail->Body    = "
				      <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
							    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;'>
							      <tr>
							        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
							        <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;''>
							          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

							            <!-- START CENTERED WHITE CONTAINER -->
							            <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;''>Request to reset the password in your stable dashboard.</span>
							            <table class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;''>

							              <!-- START MAIN CONTENT AREA -->
							              <tr>
							                <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
							                  <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
							                    <tr>
							                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>
							                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Hi there,</p>
							                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>To reset your password, please click the button below. This will take you to a screen where you can input a new password.</p>
							                        <table border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;'>
							                          <tbody>
							                            <tr>
							                              <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;'>
							                                <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;'>
							                                  <tbody>
							                                    <tr>
							                                      <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #6180A2; border-radius: 5px; text-align: center;'> <a href='".$_SERVER['SERVER_NAME']."/egnimaracing/recover/password.php?code=$code' target='_blank' style='display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'> Reset password</a> </td>
							                                    </tr>
							                                  </tbody>
							                                </table>
							                              </td>
							                            </tr>
							                          </tbody>
							                        </table>
						                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>Alternatively, click this reset link <a href='".$_SERVER['SERVER_NAME']."/egnimaracing/recover/password.php?code=$code'>Reset Password</a></p>
							                        <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;'>if you have a problem, please email: herbie@enigmaracing.net</p>
							                      </td>
							                    </tr>
							                  </table>
							                </td>
							              </tr>

							            <!-- END MAIN CONTENT AREA -->
							            </table>

							          <!-- END CENTERED WHITE CONTAINER -->
							          </div>
							        </td>
							        <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;'>&nbsp;</td>
							      </tr>
							    </table>
							  </body>
						";
						if (!$mail->send()) {
						    echo 'Mailer Error: '. $mail->ErrorInfo;
						} else {
								$message = [
										"title" => "Password reset link sent",
								    "message" => "Please check your email",
								    "status" => true
								];
						    echo json_encode($message);
						}
			}
			else{
				$message = [
						"title" =>'There was a problem',
				    "message" => "The email that you sent doesn't match with any member",
				    "status" => false
				];
				echo json_encode($message);
			}
		break;
		case 'resetPassword':
			$passwordHashed=hash("MD5",$password);
			$member->resetPassword($resetCode,$passwordHashed);
			$message = [
				"title" => "Password restored succesfully",
				"message" => "Your password has been restored, try to login again with your new password",
				"status" => true
			];
			echo json_encode($message);
			break;
		case 'verify':
			$login=$email;
			//Hash MD5 on the password
			$passwordLogin=hash("MD5",$password);
			$response=$member->verify($login, $passwordLogin);

			$fetch=$response->fetch_object();

			if (isset($fetch) AND $fetch->memberID > 0)
				{
						//We declare the session variables
						$_SESSION['userID']=$fetch->memberID;
						$_SESSION['name']=$fetch->fullname;
						$_SESSION['status']=$fetch->status ? 'verified':'unverified';
						$_SESSION['email']=$fetch->email;
						$_SESSION['position']=$fetch->position;
						
						if ($_POST['remember'] == 1) {
							setcookie("u",cleanString($login),time() + (60*60*24*365), "/");
							setcookie("p",$passwordLogin,time() + (60*60*24*365), "/");
						}
				}
			echo json_encode($fetch);
		break;
		case 'delete':
			$response = $member->delete($memberID);
			echo $response ? "Member has been deleted succesfully":"It can't be possible delete the user";
		break;
		case 'logout':
				//We clean the session variables
    		session_unset();
        //Destroy the session
        session_destroy();
        setcookie("u",'',time() - 10, "/");
				setcookie("p",'',time() - 10, "/");
        //We redirect the member to the login page
        header("Location: ../login.php");
		break;
		case 'show':
			$response=$member->show($memberID);
	 		echo json_encode($response);
		break;
		case 'verifyUser':
			$response = $member->verify_user($memberID);
			$message = 
			[
					"title" => "Verification successfully",
					"message" => "The member has been verified",
					"status" => true
			];
	 		echo json_encode($message);
		break;
		case 'unverifyUser':
			$response = $member->unverify_user($memberID);
			$message = 
			[
					"title" => "Unverification succesfully",
					"message" => "The member has been unverified",
					"status" => true
			];
	 		echo json_encode($message);
		break;
		case 'list':
			$response=$member->list_member();
			$data= Array();

	 		while ($reg=$response->fetch_object()){
	 			$data[]=array(
	 				"0" => $reg->status ? "<span data-toggle='tooltip' data-placement='bottom' title='It shows that the user already has been verified, if you click here, it is going to be unverified'><i class='icon-circle-check' onclick='unVerify($reg->memberID)' style='color:green;font-size:1.5em;'></i>":"<span data-toggle='tooltip' data-placement='bottom' title='It shows that the user already has not been verified yet, if you click here, it is going to be verified'><i class='icon-circle-cross' onclick='verify($reg->memberID)' style='color:red;font-size:1.5em;'></i>",
	 				"1"=>$reg->fullname,
	 				"2"=>$reg->email,
	 				"3"=>$reg->position,
	 				"4"=>'<button class="btn btn-info" onclick="editUserForm('.$reg->memberID.')"><i class="fa fa-pencil"></i></button>'.
	 					' <button class="btn btn-danger" onclick="deleteUser('.$reg->memberID.')"><i class="fa fa-close"></i></button>'
	 				);
	 		}
	 		$results = array(
				"sEcho"=>1, //Information for datatables
				"iTotalRecords"=>count($data), //We send the total records 
				"iTotalDisplayRecords"=>count($data), //We send the total records to be visualize
	 			"aaData"=>$data);
	 		echo json_encode($results);
			break;
		case 'list-payments':
					$response=$syndicateDetails->view_payments();
					$data= Array();

			 		while ($reg=$response->fetch_object()){
			 			$data[]=array(
			 				"0"=>$reg->name,
			 				"1"=>$reg->buyerEmail,		 				
			 				"2"=>$reg->horse,
			 				"3"=>$reg->syndicate_name,
			 				"4"=>$reg->start,
			 				"5"=>$reg->no_share,
			 				"6"=>$reg->method
				 				);
			 		}
			 		$results = array(
			 			"sEcho"=>1, //Information for datatables
			 			"iTotalRecords"=>count($data), //We send the total records 
			 			"iTotalDisplayRecords"=>count($data), //We send the total records to be visualize
			 			"aaData"=>$data);
			 		echo json_encode($results);
		break;
		case 'myStable':
					$response=$syndicateDetails->myStable($_SESSION['email']);
					$data= Array();
			 		while ($reg=$response->fetch_object()){
			 			if ($reg->no_share == "" OR $reg->no_share == 0) {
			 			}
			 		else{

			 			$data[] = array(
			 				"0"=>$reg->type,
			 				"1"=>$reg->horse,
			 				"2"=>$reg->sire,
			 				"3"=>$reg->trainer,
			 				"4"=>$reg->syndicate_percentage,
			 				"5"=>$reg->no_share . '/' .$reg->total_shares,
			 				"6"=>$reg->next_renewal
				 				);

			 			}
			 		}
		 			$results = array(
		 			"sEcho"=>1, //Information for datatables
		 			"iTotalRecords"=>count($data), //We send the total records 
		 			"iTotalDisplayRecords"=>count($data), //We send the total records to be visualize
		 			"aaData"=>$data);
		 			echo json_encode($results);
		break;
		case 'list-syndicates':
			$response=$syndicateDetails->view_syndicate();
			$data= Array();

		 		while ($reg=$response->fetch_object()){
		 			$data[] = array(
		 				"0" => $reg->enigma_racing,
		 				"1" => $reg->horse,
		 				"2" => $reg->trainer,
		 				"3" => $reg->type,
		 				"4" => $reg->syndicate_percentage,
		 				"5" => $reg->total_shares,
		 				"6" => $reg->next_renewal,
		 				"7" => $reg->syndicator,
		 				"8" => $reg->sire,
		 				"9" =>$reg->nro_members
			 				);
		 		}
		 		$results = array(
		 			"sEcho"=>1, //Information for datatables
		 			"iTotalRecords"=>count($data), //We send the total records 
		 			"iTotalDisplayRecords"=>count($data), //We send the total records to be visualize
		 			"aaData"=>$data);
		 		echo json_encode($results);
				break;
}	

 ?>