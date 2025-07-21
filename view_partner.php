<?php
include("dbconnect.php");
$yearid=date('Y');
$tm = date("Y-m-d");
$tmtime = date("H:i:s");
			
	$unique_id = $_POST['unique_id'];

	$bquery = "SELECT unique_id,comp_name,comp_address,comp_pin,comp_image,comp_email,comp_type,comp_stat FROM tbl_companies WHERE unique_id = ?";
	$stmt = $pdo->prepare($bquery);
	$stmt->bindParam(1, $unique_id, PDO::PARAM_STR, 12);
	$stmt->execute();

	$num = $stmt->rowCount();
	if ($num > 0)
    {
        $stmt->bindColumn('comp_name', $comp_name);
        $stmt->bindColumn('comp_address', $comp_address);
        $stmt->bindColumn('comp_pin', $comp_pin);
        $stmt->bindColumn('comp_image', $comp_image);
        $stmt->bindColumn('comp_email', $comp_email);
        $stmt->bindColumn('comp_type', $comp_type);
        $stmt->bindColumn('comp_stat', $comp_stat);
        
        $row = $stmt->fetch( PDO::FETCH_BOUND );
        
        if($comp_image=="")
        {
            $oldimageloc = "";
            $comp_image = "assets/img/profile-img.jpg";
        }
        else
        {
            $oldimageloc = $comp_image;
        }
    } 
    else
    {
        $comp_name = "";
        $comp_address = "";
        $comp_pin = "";
        $comp_email = "";
        $comp_image = "assets/img/profile-img.jpg";
        $oldimageloc = "";
        $comp_type = "";
        $comp_stat = "0";
    }
    
    if(isset($_POST['addsubmit']))
    {
       
        $tm = date("Y-m-d");
        $oldimageloc =  $_POST['oldimageloc'];
        $filetype = $_POST['filetype'];
        $name = $_FILES["userfile"]["name"];
        $tmp_name = $_FILES["userfile"]["tmp_name"];
        $t=time();

        $unique_id = $_POST['unique_id'];
        $comp_name = $_POST['comp_name'];
        $comp_address = $_POST['comp_address'];
        $comp_pin = $_POST['comp_pin'];
        $comp_email = $_POST['comp_email'];
        $comp_image = $_POST['comp_image'];
        $comp_stat = $_POST['comp_stat'];
        

        $checkquery = "SELECT unique_id,comp_name,comp_address,comp_pin,comp_image,comp_email,comp_type FROM tbl_companies WHERE unique_id = ?";
        $result = $pdo->prepare($checkquery);
        $result->bindParam(1, $unique_id);
        $result->execute();
        $num = $result->rowCount();


        if ($num > 0)
        {
            
            $upquery = "UPDATE tbl_companies SET comp_name=?,comp_address=?,comp_pin=?,comp_email=?,comp_stat=? WHERE unique_id =?";
            $upresult = $pdo->prepare($upquery);
            $upresult->bindParam(1, $comp_name);
            $upresult->bindParam(2, $comp_address);
            $upresult->bindParam(3, $comp_pin);
            $upresult->bindParam(4, $comp_email);
            $upresult->bindParam(5, $comp_stat);
            $upresult->bindParam(6, $unique_id);
            $upresult->execute();
           
            if ($name!="")
              {
                  //start upload
                  $location="assets/$filetype/$t$name";
                  move_uploaded_file($tmp_name,$location);
                 
                  $query = "UPDATE tbl_companies SET comp_image='$location' WHERE unique_id=?";
                  $imageloc = $location;
                  $imgresult = $pdo->prepare($query);
                  $imgresult->bindParam(1, $unique_id);
                  $imgresult->execute();
                 
          
                  unlink($oldimageloc);
              }
              header("Location: all_partners.php");

        } 
		 
      else
      {
        
          
            $upquery = "INSERT INTO tbl_companies(comp_name,comp_address,comp_pin,comp_email,comp_type,comp_stat) 
            VALUES(?,?,?,?,'0')";
            $upresult = $pdo->prepare($upquery);
            $upresult->bindParam(1, $comp_name);
            $upresult->bindParam(2, $comp_address);
            $upresult->bindParam(3, $comp_pin);
            $upresult->bindParam(4, $comp_email);
            $upresult->bindParam(5, $comp_stat);
            
            $upresult->execute();
           

            if ($name!="")
              {
                  //start upload
                  $location="assets/$filetype/$t$name";
                  move_uploaded_file($tmp_name,$location);
                 
                  $query = "UPDATE tbl_companies SET comp_image='$location' WHERE unique_id=?";
                  $imageloc = $location;
                  $imgresult = $pdo->prepare($query);
                  $imgresult->bindParam(1, $unique_id);
                  $imgresult->execute();
                
          
                  unlink($oldimageloc);
              }
              header("Location: all_partners.php");
                          
      }
          
    }
		
    ?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php');?>
<body>
<?php include('index_header.php');?>
<?php include('index_sidebar.php');?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Partner Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_dashboard.php">Admin</a></li>
        <li class="breadcrumb-item"><a href="all_partners.php">All Partners</a></li>
        <li class="breadcrumb-item active">Edit Partner</li>
      </ol>
    </nav>
  </div>
  <section class="section profile">
    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
      <input type="hidden" id ="oldimageloc" name ="oldimageloc" value="<?php echo $oldimageloc;?>"/>
      <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
      <input type="hidden" name="filetype" value="compimage" />
      <input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Partner Profile</h5>
              
              
                <div class="col-12 d-flex flex-column align-items-center mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Partner Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img id="estpic" src="<?php echo $comp_image;?>" alt="" width="200px">
                        <div class="pt-2">
                            <input name="userfile" id="userfile" type="file" style="width: 0.1px;height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;" onchange="readURL(this);" />
                            <label for="userfile">Browse Photo</label>
                        </div>
                      </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Company Name</label>
                  <input type="text" class="form-control" name="comp_name" value="<?php echo htmlspecialchars($comp_name); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Company Email</label>
                  <input type="email" class="form-control" name="comp_email" value="<?php echo htmlspecialchars($comp_email); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Company Address</label>
                  <input type="text" class="form-control" name="comp_address" value="<?php echo htmlspecialchars($comp_address); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Status</label>
                  <div class="mb-2">
                    <?php if ($comp_stat == 1): ?>
                      <span class="badge bg-success" style="font-size:1rem;">Active</span>
                    <?php else: ?>
                      <span class="badge bg-danger" style="font-size:1rem;">Inactive</span>
                    <?php endif; ?>
                  </div>
                  <select class="form-select" name="comp_stat" required>
                    <?php
                    if($comp_stat =="1")
                      {
                        ?>
                        <option value="1" >Active</option>
                        <option value="0">Inactive</option>
                        <?php
                      }
                    else
                      {
                        ?>
                        <option value="0">Inactive</option>
                        <option value="1" >Active</option>
                        
                        <?php
                      }
                    ?>
                    
                  </select>
                </div>
            
                <div class="col-md-6">
                  <label class="form-label">PIN (leave blank to keep current)</label>
                  <input type="password" class="form-control" name="comp_pin" minlength="4" value="<?php echo htmlspecialchars($comp_pin); ?>">
                  <div class="form-text">Enter a new PIN to change it, or leave blank to keep current. Minimum 4 characters.</div>
                </div>
                    </br>
              <div class="col-12">
                <button type="submit" class="btn btn-primary" name="addsubmit">Update Partner</button>
                <a href="all_partners.php" class="btn btn-secondary">Back</a>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      </form>
  </section>
</main>
<?php include('footer.php');?>
<script>
	var debugScript = true;	
		function readURL(input)
        {
          var url = input.value;
          var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
          if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
              var reader = new FileReader();

              reader.onload = function (e)
                {
                  $('#estpic').attr('src', e.target.result);
                }

              reader.readAsDataURL(input.files[0]);
            }
          else
          {
            $('#estpic').attr('src', '/assets/img/image.png');
          }
	      }
	</script>
</body>

</html> 