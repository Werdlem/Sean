<?php include_once('DAL/Production_PDOConnection.php');
$productDal = new products();
?>
    <title>Add Customer</title>
    </head>
<body>
<div class="panel panel-primary" style="width:49%; float:left">
<div class="panel-heading" style="text-align:center;"><h3>Add Customer</h3></div>
<div class="panel-body">
    <form method="post" id="add_allocation" action="?action=action">
        <div>
            <label for="allocated_name">Allocation Name</label>
            <input id="allocated_name" name="allocated_name" class="form-control" type="text" />
            <span id="notesInfo"></span>
        </div>
        <br />
         <button type="submit" class="btn btn-primary" name="add_allocation" id="add_allocation" >Add</button>
        </form>
        </div>
        </div>
</body>
</html>