<!-- This file is used for reference purpose which represents modal popup-->

<head>
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- <link href="../css/modern-business.css" rel="stylesheet"> -->

</head>

<body>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <script src="../js/jquery.toaster.js"></script>

    <script>
     
      $(document).ready(function() { 
        $("#saveUser").click(function(e){
          userName = $("#userName").val();
          password = $("#password").val();
          contactNumber = $("#contactNumber").val();
          emailId = $("#emailId").val();
          $.ajax({
              type: 'post',
              url: 'user_details.php',
              data: {'action': 'create_user', 'username': userName, 'password': password, 'emailId':emailId, 'contactNumber':contactNumber},
              success: function (response) {
                  $("#userName").val("");
                  $("#password").val("");
                  $("#contactNumber").val("");
                  $("#emailId").val("");
                  $("#addUserModal").modal('hide');
                  $.toaster({ message : 'user created successfully', title : 'Success', priority : 'success' });
              }
          });
        });
      });
    </script>  

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal" >Add User</button>

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="userName" class="col-form-label">User Name:</label>
            <input type="text" class="form-control" id="userName">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Password:</label>
            <input type="text" class="form-control" id="password">
          </div>
          <div class="form-group">
            <label for="emailId" class="col-form-label">Email Id:</label>
            <input type="text" class="form-control" id="emailId">
          </div>
          <div class="form-group">
            <label for="contactNumber" class="col-form-label">Contact Number:</label>
            <input type="text" class="form-control" id="contactNumber">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="saveUser" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

</body>