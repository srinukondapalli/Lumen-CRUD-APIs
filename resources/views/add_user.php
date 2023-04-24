<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<ul class="nav justify-content-center p-2 bg-dark mb-5">
  <li class="nav-item">
    <a class="nav-link active text-light" aria-current="page" href="<?=url('/')?>">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-light" href="<?=url('/create')?>">Add User</a>
  </li>
  <!-- <li class="nav-item">
    <a class="nav-link text-light" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-light" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
  </li> -->
</ul>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center text-success"><i class="fa-solid fa-user-plus m-2"></i>Create User</h2>
            <form style="width:50%;margin:auto">
            <div class="alert alert-dismissible fade show alert-pop-up" role="alert">
            <i class="fa-solid fa-message-smile"></i><span class="toast-msg"></span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">@Username</span>
                <input type="text" class="form-control username" placeholder="Username">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">@Email</span>
                <input type="email" class="form-control email" placeholder="Email address">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">@Password</span>
                <input type="password" class="form-control password" placeholder="Password">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">@Confirm Password</span>
                <input type="password" class="form-control cpassword" placeholder="Confirm Password">
            </div>
            <input type="button" class="btn btn-success create" value="Create user" id="create">
            </form>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const baseUrl = '<?=url()."/"?>';
    $('.alert-pop-up').hide();

    $('#create').click(function()
    {
        var name      = $('.username').val();
        var email     = $('.email').val();
        var password  = $('.password').val();
        var cpassword = $('.cpassword').val();
        $.ajax({
            url     : baseUrl + 'register',
            type    : 'POST',
            headers : {'Api-Token':'Authenticated-by-Srinu'},
            data    : {username:name,email:email,password:password,password_confirmation:cpassword},
            success : function(resp)
            {
                if(resp.status)
                {
                    $('.toast-msg').text(resp.message)
                    $('.alert-pop-up').addClass('alert-success');
                    $('.alert-pop-up').show();
                    setTimeout(function() {
                    location.href = baseUrl;
                }, 2000); 
                }
                else if(resp.message)
                {
                    $('.toast-msg').text(resp.message)
                    $('.alert-pop-up').addClass('alert-danger');
                    $('.alert-pop-up').show();
                }
                else
                {
                    $('.toast-msg').text('User registration failed!!')
                    $('.alert-pop-up').addClass('alert-danger');
                    $('.alert-pop-up').show();
                } 
            }
        })

    });
    $(document).click(function(){
        $('.alert-pop-up').hide();
        $('.toast-msg').text('');
        $('.alert-pop-up').removeClass('alert-danger');
        $('.alert-pop-up').removeClass('alert-success');
    });
    
</script>
</body>
</html>