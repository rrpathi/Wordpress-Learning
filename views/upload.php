<?php 
global $wpdb;
$table_name = $wpdb->prefix.'dropbox_details';
$data = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
if(!empty($data)){ ?>
  <html>
<head>
  <title></title>
</head>
<style type="text/css">
  .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
  margin-top: 20px;
}

.btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
}

.upload-btn-wrapper input[type=submit] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>
<body>
  <!-- <form action="#" method="post" id="form-submit"> -->
    <h1 id="message"></h1>
  <div class="upload-btn-wrapper">
  <button class="btn">Upload a file</button>
  <input type="submit" name="fileupload" id="form-submit" />
  </div>
  <!-- </form> -->
</body>
</html>
<?php }else{ ?>
    <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Dropbox Account Details</h2>

  <form action="#">
    <div class="form-group">
      <label for="email">App Key</label>
      <input type="text" class="form-control" id="app_key" placeholder="Enter App Key" name="app_key">
    </div>
    <div class="form-group">
      <label for="pwd">App Secret</label>
      <input type="text" class="form-control" id="app_secret" placeholder="Enter App Secret" name="app_secret">
    </div>
     <div class="form-group">
      <label for="pwd">Access Token</label>
      <input type="text" class="form-control" id="access_token" placeholder="Enter Access Token" name="access_token">
    </div>
    <button type="button" id="add_dropbox_account_details" class="btn btn-default">Add Dropbox Details</button>
  </form>
</div>
</body>
</html>
<?php } ?>
