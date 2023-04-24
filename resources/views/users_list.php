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
            <div class="alert alert-dismissible fade show alert-pop-up alert-success alert-box" style="width:50%;margin-left:auto" role="alert">
            <span class="text-center flash-msg"></span>
            <button type="button" class="btn-close close-butn" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <h2 class="text-center text-success"><i class="fa-solid fa-users m-2 "></i>Users list</h2>
            <table class="table table-striped ">
                <thead>
                    <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Edit | Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($userList) && !empty($userList))
                    {
                        $Sno = 1;
                        foreach($userList as $users)
                        {
                    ?>        
                        <tr>
                        <th scope="row"><?=$Sno?></th>
                        <td><?=ucfirst($users->username)?></td>
                        <td><?=$users->email?></td>
                        <td><?=$users->created_at?></td>
                        <td>
                            <i class="fa-solid fa-pen-to-square text-primary p-2 btn" data-bs-toggle="modal" data-bs-target="#editModal-<?=$users->id?>"></i>
                            <div class="modal fade" id="editModal-<?=$users->id?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Profile <?=$users->id?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form class="update-form-<?=$users->id?>">
                                <div class="input-group mb-3">
                                        <span class="input-group-text">@Username</span>
                                        <input type="text" class="form-control username" name="username" value="<?=$users->username?>">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@Email</span>
                                        <input type="email" class="form-control email" name="email" value="<?=$users->email?>">
                                    </div>
                                    <input type="hidden" class="form-control id" name="id" value="<?=$users->id?>">
                                    <button type="button" class="btn btn-primary update-user" id="<?=$users->id?>">Update</button>
                                </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            <i class="fa-sharp fa-solid fa-trash text-danger p-2 btn delete-user" id="<?=$users->id?>"></i>
                        </td>
                        </tr>
                    <?php
                        $Sno = $Sno + 1;

                        }
                    }
                    else
                    {
                    ?>
                    <tr>
                    <td colspan=5 class="text-center">No Records</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const baseUrl = '<?=url()."/"?>';
    $('.alert-box').hide();
    $('.update-user').click(function()
    {
        var tableId = this.id;
        var data    = $('.update-form-'+tableId);
        $.ajax({
            url     : baseUrl + 'update',
            type    : 'PATCH',
            headers : {'Api-Token':'Authenticated-by-Srinu'},
            data    : $('.update-form-'+tableId).serialize(),
            success : function(resp)
            {
                $('.modal').modal('hide');
                $('.flash-msg').text(resp.message)
                $('.alert-box').show();
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });

    });

    $('.delete-user').click(function()
    {
        let message = prompt("Please enter DELETE to confirm:",'DELETE');
        if(message == 'DELETE')
        {
            var tableId = this.id;
            $.ajax({
            url     : baseUrl + 'delete',
            headers : {'Api-Token':'Authenticated-by-Srinu'},
            type    : 'DELETE',
            data    : {id:tableId},
            success : function(resp)
            {
                $('.flash-msg').text(resp.message)
                $('.alert-box').show();
                setTimeout(function() {
                    location.reload();
                }, 2000);  
            }
        });
        }
    })

</script>
</body>
</html>