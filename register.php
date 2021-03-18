<?php
include_once("config.php");
session_start();

$error = false;
if (isset($_POST['signup'])) {
	$number    = mysqli_real_escape_string($conn, $_POST['number']);
    $numberb   = mysqli_real_escape_string($conn, $_POST['numberb']);
	$email     = mysqli_real_escape_string($conn, $_POST['email']);
	$password  = mysqli_real_escape_string($conn, $_POST['password']);
	$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);	
    
	if(strlen($number)!= 12 && strlen($number)!= 14){
        $error = true;
        $number_error ="Ο αριθμός παροχής πρέπει να αποτελείται απο 12 ψηφία για παροχές ηλεκτρισμού και απο 14 ψηφία για παροχές φυσικού αερίου";
    }
    if(strlen($numberb)!= 9) {
        $error = true;
        $numberb_error="Το ΑΦΜ πρέπει να αποτελείται απο 9 ψηφία";
     }
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$email_error = "Η τιμή δεν αντιστοιχεί σε έγκυρο email.";
	}
	if(strlen($password) < 6) {
        
		$error = true;
		$password_error = "Ο κωδικός πρόσβασης πρέπει να αποτελείται τουλάχιστον από 6 χαρακτήρες και να περιέχει τουλάχιστον ένα πεζό γράμμα, ένα κεφαλαίο γράμμα και έναν αριθμό.";
	}
    
    
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Οι κωδικοί πρόσβασης δεν ταιριάζουν";
	}
	if (!$error) {
		if(mysqli_query($conn, "INSERT INTO users(number, numberb, user , pass) VALUES('" . $number . "', '" . $numberb . "','" . $email . "', '" . md5($password) . "')")) {
			$success_message = "Η εγγραφή σας καταχωρήθηκε επιτυχώς";
		} else {
			$error_message = "Τα στοιχεία που καταχωρήσατε υπάρχουν ήδη , παρακαλώ ξαναδοκιμάστε";
		}
	}
}
?>



<head>
    
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="form.css" media="all">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    
</head>


<form role="form" class="enikos" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
    <div class="container " >
       <div class="row ">
          <div class="col-sm3 ">
                <h3 class="text-center text-white " >Εγγραφή</h3>
                <hr class="mb-3">
                    
					<div class="form-group">
                        <h6 class="text-white " >Αριθμός παροχής:</h6>
						<label for="number" class="form-label">Αριθμός παροχής:</label>
						<input class="form-control" type="text" name="number"  required="required" maxlength="14" />
						<span class="bg-danger text-white"><?php if (isset($number_error)) echo $number_error; ?></span>
					</div>
              
                    <div class="form-group">
                        <h6 class="text-white " >ΑΦΜ:</h6>
						<label for="number" class="form-label">ΑΦΜ:</label>
						<input class="form-control" type="text" name="numberb"  required="required" maxlength="9" />
						<span class="bg-danger text-white"><?php if (isset($numberb_error)) echo $numberb_error; ?></span>
					</div>	
              
					<div class="form-group">
                        <h6 class="text-white " >Όνομα χρήστη (email):</h6>
						<label for="number" class="form-label">Όνομα χρήστη (email):</label>
						<input class="form-control" type="email" name="email"  required value="<?php if($error) echo $email; ?>"  />
						<span class="bg-danger text-white"><?php if (isset($email_error)) echo $email_error; ?></span>
                 
                    </div>

					
                     <div class="form-group">
                        <h6 class="text-white " >Κωδικός πρόσβασης:</h6>
						<label for="number" class="form-label">Κωδικός πρόσβασης:</label>
                        <input class="form-control" id="jq" type="password"  name="password"  required  />
                        <span class="bg-danger text-white"><?php if (isset($password_error)) echo $password_error; ?></span>
                         <script>
                          $( "#jq" ).click(function() {
                          alert( "Ο κωδικός πρόσβασης πρέπει να αποτελείται τουλάχιστον από 6 χαρακτήρες και να περιέχει τουλάχιστον ένα πεζό γράμμα, ένα κεφαλαίο γράμμα και έναν αριθμό." );
                           });
                         </script>
					</div>
              
					<div class="form-group">
                        <h6 class="text-white " >Επαλήθευση κωδικού πρόσβασης</h6>
						<label for="number" class="form-label">Επαλήθευση κωδικού πρόσβασης:</label>
						<input class="form-control"  type="password" name="cpassword"  required />
						<span class="bg-danger text-white"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
					</div>
                    
                   <div class="form-group">
                        <input type="checkbox" id="accept_terms_and_conditions"  name="checkbox" value="check"/>
                        <label for="accept_terms_and_conditions" class="text-white "  id="accept_privacy_policy_label">Αποδέχομαι τους <a href="https://assets.intelencdn.net/protergia/pdf/terms/el/protergia_terms.pdf" target="_blank" class="text-white "  >Όρους & Προϋποθέσεις χρήσης</a> αυτής της υπηρεσίας</label>
                   </div>
                    <div class="form-group text-center">
                        <input class="text-center btn btn-primary" type="submit" name="signup" id="register"  value="Εγγραφή"  onclick="if(!this.form.checkbox.checked){alert('Πρέπει να αποδεχτείτε τους όρους και τις προϋποθέσεις χρήσης αυτής της υπηρεσίας για να καταχωρηθεί η εγγραφή σας.');return false}"  />
                    </div>
         </div>
       </div>
</form>
			<span class=" bg-success text-white" ><?php if (isset($success_message)) { echo $success_message; } ?></span>
			<span class= "bg-danger text-white" ><?php if (isset($error_message)) { echo $error_message; } ?></span>
		
	
	

    
    
    
    
    
    
    
    
    
