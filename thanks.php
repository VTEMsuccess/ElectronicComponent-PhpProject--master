<!-- Start Including Header -->
<?php
include ('./dbconnection.php');
include ('./mainInclude/header.php');

if (isset ($_SESSION['is_login'])) {
    $nm_email = $_SESSION['userLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<div class="thanks">
    <h4>Cảm ơn đã đặt hàng! Chúng tôi sẽ lên đơn cho bạn trong thời gian sớm nhất :></h4>
    <a href="http://localhost/ElectronicComponent-master/Customer/myOrders.php">>>>xem thông tin đơn hàng của bạn!</a>
</div>

<style>
    .thanks{
        text-align: center;
        color: red;
        border: 1px solid #666;
        border-radius: 1rem;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 24px;
    }
</style>


<!-- Start Including Footer -->
<?php
include ('./mainInclude/footer.php')
    ?>