<!-- Start Including Header -->
<?php
include ('./dbconnection.php');
include ('./mainInclude/header.php');

if (isset ($_SESSION['is_login'])) {
    $nm_email = $_SESSION['userLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}

// Lấy thông tin người dùng
$sql = "SELECT * FROM nguoimua WHERE nm_email='$nm_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nm_id = $row["nm_id"];
    $nm_email = $row["nm_email"];

}
$sql_diaChi = "SELECT dc_sonha as sonha , dc_thanhpho as tentp, dc_tinh as tentinh, dc_xa as tenxa, dc_sdt as sdt, dc_hoten as hoten
               FROM diachi
               WHERE nm_email = '$nm_email'";
$result = $conn->query($sql_diaChi);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tentp = $row["tentp"];
        $tentinh = $row["tentinh"];
        $tenxa = $row["tenxa"];
        $sonha = $row["sonha"];
        $sdt = $row["sdt"];
        $hoten = $row["hoten"];

    }
}
?>

<div class="container text-center">
    <div class="row">
        <div class="col-9" style="min-height: 480px;">
            <?php
            if (isset ($_SESSION['cart']) && (count($_SESSION['cart']) > 0)) {
                ?>
                <!-- End Including Header -->
                <h1 style="text-align: center;">Thông tin sản phẩm</h1>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Hình</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody id="gioHang">
                        <?php
                        $tongTien = 0;
                        $i = 0;
                        $tongSoLuongSanPham = 0;
                        foreach ($_SESSION['cart'] as $sanpham) {
                            $thanhTien = $sanpham[3] * $sanpham[4];
                            $tongTien += $thanhTien;
                            $tongSoLuongSanPham += $sanpham[4];
                            echo '
                            <tr>
                                <td>' . ($i + 1) . '</td>
                                <td><img src="' . $sanpham[2] . '" width="100"></td>
                                <td>' . $sanpham[1] . '</td>
                                <td>' . $sanpham[3] . '</td>
                                <td>
                                    ' . $sanpham[4] . '
                                </td>
                                <td>' . $thanhTien . '</td>
                            </tr>
                        ';
                            $i++;
                        }
                        ?>
                    </tbody>
                    <tbody id="tongDonHang">
                        <tr>
                            <td colspan="5"><strong>Tổng đơn hàng</strong></td>
                            <td style="background-color: #CCC;">
                                <?php echo $tongTien ?>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-3   ">
                <h4 style="text-align: center;">Thông tin nhận hàng</h4>
                <form action="thanhtoan.php" method="POST">
                    <input type="hidden" name="tongdonhang" value="<?= $tongTien ?>">
                    <input type="hidden" name="soLuongSanPham" value="<?= $tongSoLuongSanPham ?>">
                    <table class="datHang" style="height: 300px; width: 100%;">
                        <tr>
                            <td><input type="text" name="hoten" placeholder="Nhập họ tên" value="<?= $hoten ?>"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="diachi" placeholder="Nhập địa chỉ"
                                    value="<?php echo "$sonha, ", "$tenxa, ", "$tentinh, ", "$tentp" ?>"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="email" placeholder="Nhập email" value="<?= $nm_email ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="sodienthoai" placeholder="Nhập số điện thoại" value="<?= $sdt ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><input type="text" name="ghichu" placeholder="Ghi chú" value=""></td>
                        </tr>
                        <tr>
                            <td>Phương thức thanh toán <br>
                                <!-- <input type="radio" name="pttt" value="1" checked> Thanh toán khi nhận hàng <br> -->
                                <input type="radio" name="pttt" value="2" checked> Thanh toán qua thẻ ATM MOMO <br>
                            </td>
                        </tr>

                        <tr>
                            <td><input type="submit" value="Đặt hàng" name="payUrl"></td>
                        </tr>
                    </table>
                </form>
                <?php
            } else {
                echo '<br> Giỏ hàng rỗng. Bạn muốn đặt hàng không <a href="index.php"> đặt hàng </a>';
            }
            ?>
        </div>
    </div>
</div>

<!-- update thanh toan qua the ATM 1/05/2024  -->
<style>

/* Reset CSS */

/* Container */
.right-modal-middle {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 10px; /* Khoảng cách giữa các cột */
}

/* Column */
.PaymentContent_column {
    flex-basis: calc(33.33% - 10px);
    padding: auto;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: auto;
    align-items: center;
}

/* Title */
.PaymentContent_title {
    font-size: 24px;
    margin-bottom: 10px;
}

/* Instruction */
.PaymentContent_instruction {
    list-style-type: none;
    padding-left: 0;
}

.PaymentContent_instruction li {
    margin: 10px;
    color: #555;
}

/* Notice */
.PaymentContent_notice {
    margin-top: 10px;
    font-style: italic;
    color: #888;
}

.PaymentContent_bank-info{
    margin-top: 40px;
}


.payment_QR{
    width: 355px;
    height: 485px;
}

span{
    color: black;
}

.Pay_Note{
    padding: top 40px ;
    margin: 20px;
}

</style>

<!-- hết update thanh toan qua the ATM 1/5/2024  -->

<div class="right-modal-middle">
    <div class="PaymentContent_column">
        <h2 class="PaymentContent_title">Chuyển khoản bằng QR</h2>
        <div class="PaymentContent_bank-detail">
            <div class="PaymentContent_qr-code">
                <img class="payment_QR" src="./image/pay/QR.jpg">
            </div>
            <ul class="PaymentContent_instruction">
                <li><b>Bước 1</b>: Mở app ngân hàng và quét mã QR.</li>
                <li><b>Bước 2</b>: Đảm bảo nội dung chuyển khoản là <strong>Họ và Tên + sdt</strong>.</li>
                <li><b>Bước 3</b>: Thực hiện thanh toán.</li>
            </ul>
        </div>
    </div>

    <div class="PaymentContent_column">
        <h2 class="PaymentContent_title">Chuyển khoản thủ công</h2>
        <div class="PaymentContent_bank-info">
            <div class="PaymentContent_bank-info-item">
                <div class="PaymentContent_label"><b>Số tài khoản</b></div>
                <div class="PaymentContent_content">1016370230</div>
            </div><br/>
            <div class="PaymentContent_bank-info-item">
                <div class="PaymentContent_label"><b>Tên tài khoản</b></div>
                <div class="PaymentContent_content">VÕ THÀNH EM</div>
            </div><br/>
            <div class="PaymentContent_bank-info-item">
                <div class="PaymentContent_label"><b>Nội dung</b></div>
                <div class="PaymentContent_content">
                    <p>Họ và Tên + sdt</p>
                    <div class="PaymentContent_copy-notice"><b>Bạn chú ý điền nội dung chuyển khoản nhé!</b> <p><b>Ví dụ</b>: <i>Nguyễn Văn A  0939053465</i></p></div>
                </div>
            </div><br/>
            <div class="PaymentContent_bank-info-item">
                <div class="PaymentContent_label"><b>Chi nhánh</b></div>
                <div class="PaymentContent_content">Vietcombank Lấp Vò</div>
            </div>
        </div>
    </div>

    <div class="PaymentContent_column">
        <h2 class="PaymentContent_title"><Strong>Lưu ý</Strong></h2>
        <p class="PaymentContent_notice"> <span>Tối đa 5 phút sau thời gian chuyển khoản, hệ thống sẽ gửi tin nhấn sms phản hồi cho bạn. Trường hợp nếu không thấy phản hồi vui lòng liên hệ ngay bộ phận hỗ trợ của chúng tui</span> .</p>
        <div class="contact">
            <div class="PaymentContent_contact-item">
                <span class="PaymentContent_text"> <b>hot line</b>: 0939.053.465</span>
            </div>
            <div class="PaymentContent_contact-item">
                <span class="PaymentContent_text"> <b>Email</b>: vothanhem10@gmail.com</span>
            </div>
            <div class="PaymentContent_contact-item">
                <span class="PaymentContent_text"><b>Địa chỉ</b>: Số 01 Hẻm 216 Đường 3/2, Hưng Lợi, Ninh Kiều, Tp Cần Thơ</span>
            </div>
        </div>
    </div>
</div>

<!-- cập nhật 1/5 -->

<!-- Start Including Footer -->
<?php
include ('./mainInclude/footer.php')
    ?>