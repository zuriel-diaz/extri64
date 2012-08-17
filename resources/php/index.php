<?php
class Index{

	private $image , $ringtone , $text, $target_path, $allowed_file_type, $file_type, $encrypted_string; 

	function __construct(){ 
		$this->allowed_file_type = array('ico','png','mid','wav');
		$this->target_path = './uploads/';
		$this->image = (isset($_FILES['image']['name'])) ? basename($_FILES['image']['name']) : '';
		$this->ringtone = (isset($_FILES['ringtone']['name'])) ? basename($_FILES['ringtone']['name']) : '';
		$this->text = (isset($_POST['string'])) ? $_POST['string'] : '';
		$this->init(); 
	}

	function init(){
		if( (strlen($this->text)) > 0  ){ $this->encryptText(); }			
		elseif ( (strlen($this->ringtone)) > 0 ){ $this->encryptRingtone(); }
		elseif ( (strlen($this->image)) > 0 ){ $this->encryptImage(); }
	}

	function encryptText(){
		$this->encrypted_string = base64_encode($this->text);
		if( (strlen($this->encrypted_string)) > 0 ){ $this->showEncryptedString(); }
	}

	function encryptRingtone(){ $this->target_path .= $this->ringtone; $this->encrypt('ringtone'); }

	function encryptImage(){ $this->target_path .= $this->image; $this->encrypt('image'); }

	function encrypt($type){
		if(move_uploaded_file($_FILES[$type]['tmp_name'],$this->target_path)){
			$this->file_type = pathinfo($this->target_path, PATHINFO_EXTENSION);
			if(in_array($this->file_type,$this->allowed_file_type)){
				$this->encrypted_string = base64_encode($this->getBinaryRepresentation($this->target_path));
			if(unlink($this->target_path)){ $this->showEncryptedString(); }
			else{ echo "file can not be removed..";  }
			}else{ echo "unsupported file.."; }	
		}else{ echo "There was an error uploading the file, please try again.."; }
	}

	function getBinaryRepresentation($data){ return (fread(fopen($data,"rb"),filesize($data))); }

	function showEncryptedString(){
		?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset="utf-8"><title>X PROJECT</title>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<meta name="description" content="X Project">
				<meta name="author" content="xthr3mx">

				<link rel="stylesheet" href="../css/bootstrap.css">
				<style type="text/css">body{ padding-top: 60px; padding-bottom: 40px; }</style>
				<link rel="stylesheet" href="../css/bootstrap-responsive.css">
				<link rel="stylesheet" href="../css/hack.css">
			</head>
			<body>
				<div class="navbar navbar-fixed-top">
					<div class="navbar-inner">
						<div class="container">
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<!--<span class="icon-bar"></span>-->
							</a>
							<a class="brand" href="#">X PROJECT</a>
							<div class="nav-collapse">
								<ul class="nav">
									<li><a href="#">Home</a></li>
									<li class="active"><a href="#">Encryption</a></li>
								</ul>
							</div><!-- /.nav-collapse -->
						</div><!-- /.container  -->
					</div><!-- /.navbar-inner -->
				</div><!-- /.navbar -->
				<div class="container">
					<h3>Congratulations!</h3>
					<p>Now you can use the encrypted message on your projects</p>
					<form class="well form-horizontal">
						<textarea id="encrypted_string" name="encrypted_string" rows="9" cols="50"><?php echo $this->encrypted_string; ?></textarea>
					</form>
				</div><!-- /.container -->
			<!-- Placed at the end of the document so the page load faster -->
			<script src="../js/jquery.js"></script>
			<script src="../js/bootstrap-collapse.js"></script>
			<script src="../js/init.js"></script>
			</body>
		</html>
		<?php
	}

	function clear(){ 
		unset($_FILES['image']['name']); unset($_FILES['ringtone']['name']); 
		unset($_POST['string']); unset($this->allowed_file_type);
		unset($this->image); unset($this->ringtone); unset($this->text);
		unset($this->target_path); unset($this->encrypted_string);
	}

	function __destruct(){ $this->clear(); }
}

$index = null;
if(isset($_POST)){ $index = new Index; }

?>
