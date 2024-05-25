<?php
include ('./dbconnection.php');
include ('./mainInclude/header.php');

if (isset ($_SESSION['is_login'])) {
    $nm_email = $_SESSION['userLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<div class="payment">
    <div class="content">
        <div class="heading">
            <h3>Phương thức thanh toán</h3>
        </div>
        <div class="group">
            <div class="payment-method">
                <h3>Hãy chọn một phương thức thanh toán</h3>
                <a href="offlinepayment.php">Thanh toán khi nhận hàng</a>
                <a href="onlinepayment.php">Thanh toán Online</a>
            </div>
            <p><a href="giaoDienGioHang.php">Trở về</a></p>
        </div>

    </div>
</div>

<!-- Start Including Footer -->
<?php
include ('./mainInclude/footer.php')
    ?>

<style>
    .group {
        display: grid;
        width: 40%;
        margin: 0px auto;
        border: 1px solid #666;
        border-radius: 1rem;
        padding: 25px;
        /* transform: translate(-10%, -10%);
        position: relative; */
        text-align: center;
        background-color: #FDF5E6;

        p {
            font-size: 20px;
            border: 1px solid #666;
            border-radius: 1rem;
            padding: 10px;
            margin: 0 30px;
            background-color: #666;
            min-width: 10%;
            position: relative;
        }
    }

    .payment-method {

        /* position: relative; */

        a {
            display: grid;
            margin: 20px;
            font-size: 20px;
            border: 1px solid #666;
            border-radius: 1rem;
            padding: 10px;
            background-color: aqua;
            min-width: -50%;
            position: relative;
        }

        h3 {
            position: relative;
            text-align: center;
            margin: 2rem;
        }
    }

    .heading {
        position: relative;
        margin: 2rem;
    }
</style>