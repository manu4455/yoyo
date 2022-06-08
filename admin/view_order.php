<?php
session_start();
if(!isset($_SESSION['admin_email']) && ($_SESSION['admin_email']))
{ 
	header("location:index.php");
}else{
// Include database connection
include 'dbconfig/dbconfig.php';
$db = $database->open();
if(isset($_GET['order_id'])){
     $id = $_GET['order_id']; 
     $result = mysqli_query($db,"SELECT * FROM orders INNER JOIN customers ON orders.customer_id=customers.id INNER JOIN country ON customers.country=country.id INNER JOIN states ON customers.states=states.id INNER JOIN city ON customers.city=city.id WHERE orders.received = 1 AND orders.order_id = '$id' ");
}
else{
    header("location:received_order.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin | Panel</title>
    <?php include 'link.php'; ?>
</head>

<body class="bg-secondary">
    <div class="loader"></div>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include 'aside.php'; ?>
        <!-- Page Content  -->
        <div id="content">
            <?php include 'header.php'; ?>
            <div class="navigation col-12  bg-light justify-content-center justify-content-sm-left ">
                <div class="btn-group justify-content-center justify-content-sm-left">
                    <a href="all_order.php" class="btn btn-default navigator rounded-0"><i class="fa fa-eye"> Order details</i></a>
                </div>
            </div>
            <section class="main mt-2">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <div class="card " id="printPDF">
                               
                                    <div class="col-xs-12">
                                        <div class="grid invoice">
                                            <div class="grid-body">
                                                <div class="invoice-title border-bottom pb-2">
                                                    <div class="row">
                                                        <div class="col-md-12 bg-primary text-center">
                                                            <img src="../images/logo/logo.png" alt="" height="35" >
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <?php $row = $result ->fetch_assoc(); ?>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <address>
                                                                <strong>Billed To:</strong><br>
                                                                <?php echo $row['addres']." ".$row['pin']."<br>".$row['city_name']." , ".$row['state_name']." , ".$row['country_name'];  ?></br>
                                                                <strong>Phone :</strong> <?php echo $row['phone']; ?></br>
                                                                <strong>Email :</strong> <?php echo $row['email']; ?></br>
                                                            </address>
                                                        </div>
                                                        <div class="col-sm-4 text-right">
                                                            <input id="text" type="text" value="<?php echo $row['order_id']; ?>" style="width:80%" hidden>
                                                            <div id="qrcode" class="float-right " >
                                                                <h5 class="pr-1"><?php  echo $row['order_id'];  ?></h5>
                                                            </div>                                                           
                                                        </div>
                                                    </div>                                                    
                                                </div>                                                
                                                <div class="row border-bottom">
                                                    <div class="col-6">
                                                        <address>
                                                            <strong>Payment Method:</strong><br>
                                                            <?php echo $row['payment_mode']; ?>
                                                        </address>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <address>
                                                            <strong>Order Date:</strong><br>
                                                            <?php echo $row['payment_mode']; ?>
                                                        </address>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>Order List</h4>
                                                        <table class="table borderless">
                                                            <thead>
                                                                <tr class="line">
                                                                    <td><strong>S.no</strong></td>
                                                                    <td class="text-center"><strong>Title</strong></td>
                                                                    <td class="text-center"><strong>Quantity</strong></td>
                                                                    <td class="text-center"><strong>Amount</strong></td>
                                                                    <td class="text-right"><strong>Total</strong></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $total=0;
                                                                    $result=$db->query("SELECT * FROM orders INNER JOIN products ON orders.product_id=products.product_id  WHERE orders.received = 1 AND orders.order_id = '$id' ");
                                                                    $num=1;
                                                                    while ($row = $result ->fetch_assoc()) {
                                                                        $subtotal = $row['amount']*$row['quantity'];
                                                                        $total += $subtotal;
                                                                ?>
                                                                <tr >
                                                                    <td><?php echo $num; ?></td>
                                                                    <td class="text-left"><strong><?php echo $row['product_name']; ?></strong></td>
                                                                    <td class="text-center"><?php echo $row['quantity']; ?></td>
                                                                    <td class="text-center"><i class="fa fa-rupee"></i><?php echo $row['amount']; ?></td>
                                                                    <td class="text-right"><i class="fa fa-rupee"></i><?php echo $row['total_amount']; ?></td>
                                                                </tr>
                                                                    <?php 
                                                                    $num++;
                                                                }
                                                                    
                                                                    ?>
                                                            </tbody>
                                                            <tfoot class="border-top">
                                                                <tr >
                                                                    
                                                                    <td class="text-center text-dark" colspan="4">Total Amount</td>
                                                                    <td class="text-right text-dark"><i class="fa fa-rupee"></i><?php echo $total; ?></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>									
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>                                   
                            </div>
                            <div class="container-fluid">
                            <div class=" mb-4 mt-4 bg-light">
                                <div class="col-md-12"><button type="button" class="btn btn-secondary print w-100" name="print" id="btnPrint" ><i class="fa fa-print"></i> Print PDF receipt</button></div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <?php include "js/script.php"; ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#btnPrint", function () {
            html2canvas($('#printPDF')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Receipt.pdf");
                }
            });
        });
    </script>
   
  
  <script>
  var qrcode = new QRCode("qrcode");
  
  function makeCode() {
    var elText = document.getElementById("text");
  
    if (!elText.value) {
      alert("Input a text");
      elText.focus();
      return;
    }
  
    qrcode.makeCode(elText.value);
  }
  
  makeCode();
  
  $("#text").
  on("blur", function () {
    makeCode();
  }).
  on("keydown", function (e) {
    if (e.keyCode == 13) {
      makeCode();
    }
  });
      </script>
</body>
</html>
<?php 
$db = $database->close();
}
?>