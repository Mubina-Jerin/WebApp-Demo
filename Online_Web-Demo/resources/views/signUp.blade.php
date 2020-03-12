

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ছাদ কৃষি</title>

        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 </head>
 <header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
  <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img src="/images/logo.jpg" height="50 px" width="50 px">
    </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/landing"> মেইন মেনু <span class="sr-only">(current)</span></a></li>
        <li><a href="/gardener/landing">বাগান সেবী </a> </li>
        
     
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/landing/signUp">রেজিস্ট্রেশন </a></li>
        <li><a href="/landing/login">লগ ইন </a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
        
</header>
<body>
<div class="container-fluid">
<div class="row">
<div class="col-md-2">
</div>
  <div class="col-md-8" text-align="center">
          <form action="{{ route('signUp.registration') }}" method="post">
            @csrf
            
          <div class="form-group">
              <label for="userName">আপনার নাম </label>
              <input type="text" name="userName" class="form-control" id="userName">
          </div>
            <div class="form-group">
              <label for="pwd">আপনার পছন্দের পিন প্রবেশ করুন</label>
              <input type="password" name="pwd" class="form-control" id="pwd">
            </div>
            <!-- <div class="form-group">
              <label for="firstName">first Name</label>
              <input type="text" name="firstName" class="form-control" id="firstName">
            </div>

            <div class="form-group">
              <label for="lastName">last Name</label>
              <input type="text" name="lastName"class="form-control" id="firstName">
            </div> -->
            <div class="form-group">
              <label for="address">ঠিকানা</label>
              <input type="text" name="address" class="form-control" id="address">
            </div>
            <div class="form-group">
              <label for="phone_number">ফোন নাম্বার</label>
              <label for="error" ><span class="red"><?php echo $error; ?></span></label>
              <input type="text" name="phoneNumber" class="form-control" id="phone_number">
            </div>
            <!-- <div class="checkbox">
              <label><input type="checkbox"> Remember me</label>
            </div> -->
            <button type="submit" class="btn btn-default">সাইন আপ</button>

</form>   
</div> 
<div class="col-md-2">
</div>      
</div>
</div>
 </body>


</html>