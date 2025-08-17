
<script src="<?php echo public_url() ?>/site/bootstrap/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?php echo public_url() ?>/site/bootstrap/jquery.dataTables.min.css">
<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<?php if ($role == false): ?>
    <div class="wrapper">
        <div class="widget">
            <div class="title">
                <h6>Bạn không được phân quyền</h6>
            </div>
        </div>
    </div>
<?php else: ?>
<?php $this->load->view('admin/error')?>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>

    <form class="list_filter form" action="<?php echo admin_url('report/moneysystemnew') ?>" method="post">        <div class="formRow">
            <table>
                <tr>
                    <td>
                        <label for="param_name" class="formLeft" id="nameuser"
                               style="margin-left: 70px;margin-bottom:-2px;width: 100px">Từ ngày:</label></td>
                    <td class="item">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" id="toDate" name="toDate"
                                   value="<?php echo $this->input->post('toDate') ?>"> <span
                                    class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                        </div>                    </td>

                    <td>
                        <label for="param_name" style="margin-left: 20px;width: 100px;margin-bottom:-3px;"
                               class="formLeft"> Đến ngày: </label>
                    </td>
                    <td class="item">

                        <div class="input-group date" id="datetimepicker2">
                            <input type="text" id="fromDate" name="fromDate"
                                   value="<?php echo $this->input->post('fromDate') ?>"> <span
                                    class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                        </div>
                    </td>
                    <td style="">
                        <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB"
                               style="margin-left: 70px">
                    </td>
                    <td>
                        <input type="reset"
                               onclick="window.location.href = '<?php echo admin_url('report/moneysystemnew') ?>'; "
                               value="Reset" class="basic" style="margin-left: 20px">
                    </td>
                </tr>
            </table>
        </div>

    </form>

    <div class="formRow">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                        <thead>
                        <tr style="height: 20px;">
                            <td>Tiền nạp (4)</td>
                            <td>Tiền sự kiên (5)</td>
                            <td style="font-weight: 600;color: #0000ff">Tổng nạp (4) +(5)</td>
                            <td>Tiền đổi thưởng (7)</td>
                            <td>Tiền lệch đại lý (8)</td>
                            <td style="font-weight: 600;color: #0000ff">Tổng đổi thưởng (8) - (7)</td>
                            <td style="font-weight: 600;color: #0000ff">Tỉ lệ đổi thưởng ((8) -(7)) / (8) </td>
                        </tr>
                        </thead>
                        <tbody id="logactiontotal"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!--    Detail GAME    -->
    <div class="formRow">
        <div class="container">
            <div id="tabs-container">
                <ul class="tabs-menu">
                    <li class="current"><a href="#tab-1">Game</a></li>
                    <li><a href="#tab-2">Tiền vào game</a></li>
                    <li><a href="#tab-3">Tiền ra game</a></li>
                    <li hidden><a href="#tab-4">Tiền khác</a></li>
                </ul>

            <!--  TAB GAME  -->
                <div class="tab row">
                    <div id="tab-1" class="tab-content col-sm-12">

                        <!--  MINIGAME  -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Minigame & Slot</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll1" class="table table-bordered checkAll2000" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Tên game</td>
                                        <td>Trả thưởng</td>
                                        <td>Tiền cược</td>
                                        <td>Tiền hoàn trả</td>
                                        <td>Phế</td>
                                        <td class="col-sm-2">Tiền thắng trong game</td>
                                        <td>Tiền thắng tổng</td>
                                    </tr>
                                    </thead>
                                    <tbody id="logaction1"></tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng (1) :</td>
                                        <td id="totalmoneywin" style="color:#0000ff "></td>
                                        <td id="totalmoneylost" style="color: #0000ff"></td>
                                        <td id="totalmoneyother" style="color: #0000ff"></td>
                                        <td id="totalmoneyfee" style="color: #0000ff"></td>
                                        <td id="totalmoneyplay" style="color: #0000ff"></td>
                                        <td id="totalmoney" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!--  GAME BAI  -->
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Game bài</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll2" class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Tên game</td>
                                        <td>Trả thưởng</td>
                                        <td>Tiền cược</td>
                                        <td>Tiền hoàn trả</td>
                                        <td>Phế</td>
                                        <td class="col-sm-2">Tiền thắng trong game</td>
                                        <td>Tiền thắng tổng</td>
                                    </tr>
                                    </thead>
                                    <tbody id="logaction2"></tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng (2) :</td>
                                        <td id="totalmoneywinbai" style="color:#0000ff "></td>
                                        <td id="totalmoneylostbai" style="color: #0000ff"></td>
                                        <td id="totalmoneyotherbai" style="color: #0000ff"></td>
                                        <td id="totalmoneyfeebai" style="color: #0000ff"></td>
                                        <td id="totalmoneyplaybai" style="color: #0000ff"></td>
                                        <td id="totalmoneybai" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!--  GAME KHAC  -->
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Game khác</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll3" class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Tên game</td>
                                        <td>Trả thưởng</td>
                                        <td>Tiền cược</td>
                                        <td>Tiền hoàn trả</td>
                                        <td>Phế</td>
                                        <td class="col-sm-2">Tiền thắng trong game</td>
                                        <td>Tiền thắng tổng</td>
                                    </tr>
                                    </thead>
                                    <tbody id="logaction3"></tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng (3) :</td>
                                        <td id="totalmoneywingame" style="color:#0000ff "></td>
                                        <td id="totalmoneylostgame" style="color: #0000ff"></td>
                                        <td id="totalmoneyothergame" style="color: #0000ff"></td>
                                        <td id="totalmoneyfeegame" style="color: #0000ff"></td>
                                        <td id="totalmoneyplaygame" style="color: #0000ff"></td>
                                        <td id="totalmoneygame" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!--  Tinh Tong  -->
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Tổng</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Tên game</td>
                                        <td>Trả thưởng</td>
                                        <td>Tiền cược</td>
                                        <td>Tiền hoàn trả</td>
                                        <td>Phế</td>
                                        <td class="col-sm-2">Tiền thắng trong game</td>
                                        <td>Tiền thắng tổng</td>
                                    </tr>
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng = (1) + (2) + (3) :</td>
                                        <td id="summoneywin" style="color:#0000ff "></td>
                                        <td id="summoneylost" style="color: #0000ff"></td>
                                        <td id="summoneyother" style="color: #0000ff"></td>
                                        <td id="summoneyfee" style="color: #0000ff"></td>
                                        <td id="summoneyplay" style="color: #0000ff" class="col-sm-2"></td>
                                        <td id="summoney" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div id="tab-2" class="tab-content col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">

                            <!--  Money In user  -->
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <td rowspan="5"
                                            style="vertical-align: middle;text-align: center;color: #ff0000;font-weight: 600">
                                            Tiền nạp user
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tiền nạp Paywell</td>
                                        <td id="ListUserInRechargeByPaywell" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Tiền nạp Princepay</td>
                                        <td id="ListUserInRechargeByPrincePay" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Tiền nạp Oneclickpay</td>
                                        <td id="ListUserInRechargeByClickPay" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #0000ff;font-weight: 600">Tổng (4)</td>
                                        <td id="totalListUserIn" style="color: #0000ff;font-weight: 600;text-align: left"></td>

                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 30px"></td>
                                    </tr>

                                    <!--  Money In Event  -->
                                    <tr>
                                        <td rowspan="17"
                                            style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tiền sự kiện
                                        </td>
                                        <td>GiftCode</td>
                                        <td id="ListUserInEventGiftCode" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>GiftCode vận hành</td>
                                        <td id="ListUserInEventGiftCodeVH" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>GiftCode marketing</td>
                                        <td id="ListUserInEventGiftCodeMKT" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>GiftCode Agent Import</td>
                                        <td id="ListUserInEventGcAgentImport" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Refund Fee</td>
                                        <td id="ListUserInEventRefundFee" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Thưởng nhiệm vụ</td>
                                        <td id="ListUserInEventNhiemVu" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Vòng quay may mắn</td>
                                        <td id="ListUserInEventVQMM" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Vòng quay vip</td>
                                        <td id="ListUserInEventVQVIP" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Event vippoint</td>
                                        <td id="ListUserInEventEventVP" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Cashout By VP</td>
                                        <td id="ListUserInEventCashoutByVP" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>BonusTopDS</td>
                                        <td id="ListUserInEventBonusTopDS" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Event vippoint Bonus</td>
                                        <td id="ListUserInEventEventVPBonus" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Kho Báu Vq free</td>
                                        <td id="ListUserInEventKhoBauVqFree" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Nữ điệp viên Vq free</td>
                                        <td id="ListUserInEventNuDiepVienVqFree" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Siêu anh hùng Vq free</td>
                                        <td id="ListUserInEventSieuAnhHungVqFree" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Vương quốc Vin Vq free</td>
                                        <td id="ListUserInEventVuongQuocVinVqFree" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #0000ff;font-weight: 600">Tổng (5)</td>
                                        <td id="totalListUserInEvent" style="color: #0000ff;font-weight: 600; text-align: left"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 30px"></td>
                                    </tr>
                                    <tr>
                                        <td
                                                style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tổng tiền vào = (4) + (5)
                                        </td>
                                        <td colspan="2" id="totalMoneyInGame"
                                            style="vertical-align: middle;text-align: left;color: red;font-weight: 600"></td>
                                    </tr>
                                </table>                            </div>
                        </div>

                    </div>
                    <div id="tab-3" class="tab-content col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">

                                <!--  Money Out user  -->
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <td rowspan="6"
                                            style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tiền user đổi thưởng
                                        </td>
                                    <tr>
                                        <td>Rút OneclickPay </td>
                                        <td id="ListUserOutCashOutByClickPay" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Rút PrincePay </td>
                                        <td id="ListUserOutCashOutByPrincePay" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Rút về Ngân hàng </td>
                                        <td id="ListUserOutCashOutByBank" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Tiền hoàn trả khi bị lỗi</td>
                                        <td id="ListUserOutRefundRechargeError" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #0000ff;font-weight: 600">Tổng (7)</td>
                                        <td id="totalListUserOut" style="color: #0000ff;font-weight: 600;text-align: left"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 30px"></td>
                                    </tr>

                                    <!--  Money Out Money  -->
                                    <tr>
                                        <td rowspan="3"
                                            style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tiền lệch đại lý
                                        </td>
                                        <td>Đầu</td>
                                        <td id="UserMoneyuserStart" class="moneyhtml"></td>
                                    </tr>

                                    <tr>

                                        <td>Cuối</td>
                                        <td id="UserMoneyuserEnd" class="moneyhtml"></td>
                                    </tr>

                                    <tr>

                                        <td style="color: #0000ff;font-weight: 600">Tiền lệch (8)</td>
                                        <td id="UserMoney" style="color: #0000ff;font-weight: 600; text-align: left"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" style="height: 30px"></td>
                                    </tr>

                                    <tr>
                                        <td
                                                style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tổng tiền ra = (8) - (7)
                                        </td>

                                        <td colspan="2" id="totalMoneyOut"
                                            style="vertical-align: middle;text-align: left;color: red;font-weight: 600"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-content col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <td rowspan="6"
                                            style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tiền khác
                                        </td>
                                        <td>Phí chuyển khoản</td>
                                        <td id="money30" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Đổi xu</td>
                                        <td id="money31" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Phí SMS</td>
                                        <td id="money32" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Admin</td>
                                        <td id="money33" class="moneyhtml"></td>
                                    </tr>
                                    <tr>
                                        <td>Đại lý xuất giftcode</td>
                                        <td id="money34" class="moneyhtml"></td>
                                    </tr>
                                    <tr>

                                        <td style="color: #0000ff;font-weight: 600">Tổng</td>
                                        <td id="money35" style="color: #0000ff;font-weight: 600;text-align: right"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 30px"></td>
                                    </tr>

                                    <tr>
                                        <td rowspan="3"
                                            style="vertical-align: middle;text-align: center;color: red;font-weight: 600">
                                            Tiền lệch user
                                        </td>
                                        <td>Đầu</td>
                                        <td id="money36" class="moneyhtml"></td>
                                    </tr>

                                    <tr>

                                        <td>Cuối</td>
                                        <td id="money37" class="moneyhtml"></td>
                                    </tr>

                                    <tr>

                                        <td style="color: #0000ff;font-weight: 600">Tiền lệch</td>
                                        <td id="money38" style="color: #0000ff;font-weight: 600; text-align: right"></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-content col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Tiền bot</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Cộng trừ tiền bot</td>
                                        <td>Admin</td>
                                        <td>Vippoint event</td>
                                    </tr>
                                    <tr style="height: 20px;">
                                        <td id="bot1"></td>
                                        <td id="bot2"></td>
                                        <td id="bot3"></td>
                                    </tr>
                                    </thead>

                                </table>
                            </div>                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Minigame & Slot</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Tên game</td>
                                        <td>Trả thưởng</td>
                                        <td>Tiền cược</td>
                                        <td>Tiền hoàn trả</td>
                                        <td>Phế</td>
                                        <td>Tiền thắng trong game</td>
                                        <td>Tiền thắng tổng</td>
                                    </tr>
                                    </thead>
                                    <tbody id="logactionbot1"></tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng:</td>
                                        <td id="totalmoneylostbot" style="color:#0000ff "></td>
                                        <td id="totalmoneywinbot" style="color: #0000ff"></td>
                                        <td id="totalrefundbot" style="color: #0000ff"></td>
                                        <td id="totalmoneyotherbot" style="color: #0000ff"></td>
                                        <td id="totalmoneyfeebot" style="color: #0000ff"></td>
                                        <td id="totalmoneyplaybot" style="color: #0000ff"></td>
                                        <td id="totalmoneybot" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Game bài</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <thead>
                                    <tr style="height: 20px;">
                                        <td>Tên game</td>
                                        <td>Trả thưởng</td>
                                        <td>Tiền cược</td>
                                        <td>Tiền hoàn trả</td>
                                        <td>Phế</td>
                                        <td>Tiền thắng trong game</td>
                                        <td>Tiền thắng tổng</td>
                                    </tr>
                                    </thead>
                                    <tbody id="logactionbot2"></tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng:</td>
                                        <td id="totalmoneylostbaibot" style="color:#0000ff "></td>
                                        <td id="totalmoneywinbaibot" style="color: #0000ff"></td>
                                        <td id="" style="color: #0000ff">0</td>
                                        <td id="totalmoneyotherbaibot" style="color: #0000ff"></td>
                                        <td id="totalmoneyfeebaibot" style="color: #0000ff"></td>
                                        <td id="totalmoneyplaybaibot" style="color: #0000ff"></td>
                                        <td id="totalmoneybaibot" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <h4 id="" style="color: red;margin-left: 20px">Tổng</h4>
                            </div>
                            <div class="col-sm-12">
                                <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                    <tbody>
                                    <tr>
                                        <td colspan="">Tổng:</td>
                                        <td id="summoneylostbot" style="color:#0000ff "></td>
                                        <td id="summoneywinbot" style="color: #0000ff"></td>
                                        <td id="sumrefundbot" style="color: #0000ff"></td>
                                        <td id="summoneyotherbot" style="color: #0000ff"></td>
                                        <td id="summoneyfeebot" style="color: #0000ff"></td>
                                        <td id="summoneyplaybot" style="color: #0000ff"></td>
                                        <td id="summoneybot" style="color: #0000ff"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>

    .moneyhtml {
        text-align: left;
    }

    .tabs-menu {
        height: 30px;
        /*float: left;*/
        clear: both;
    }

    .tabs-menu li {
        height: 30px;
        line-height: 30px;
        float: left;
        margin-right: 10px;
        background-color: #ccc;
        border-top: 1px solid #d4d4d1;
        border-right: 1px solid #d4d4d1;
        border-left: 1px solid #d4d4d1;
    }

    .tabs-menu li.current {
        position: relative;
        background-color: #fff;
        border-bottom: 1px solid #fff;
        z-index: 5;
    }

    .tabs-menu li a {
        padding: 10px;
        text-transform: uppercase;
        color: #fff;
        text-decoration: none;
    }

    .tabs-menu .current a {
        color: #2e7da3;
    }

    .tab {
        border: 1px solid #d4d4d1;
        background-color: #fff;
        float: left;
        margin-bottom: 20px;
        width: auto;
    }

    .tab-content {
        width: 100%;
        padding: 20px;
        display: none;
    }

    #tab-1 {
        display: block;
    }

    td {
        word-break: break-all;
    }

    thead {
        font-size: 12px;
    }

    .spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-left: -50px; /* half width of the spinner gif */
        margin-top: -50px; /* half height of the spinner gif */
        text-align: center;
        z-index: 1234;
        overflow: auto;
        width: 100px; /* width of the spinner gif */
        height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
    }</style>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<script>
    $(function () {
        var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0)
        var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59)

        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: startDate,
            useCurrent : false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: endDate,
            useCurrent : false,
        });
        $('#datetimepicker1').data("DateTimePicker").maxDate(endDate);
        $('#datetimepicker2').data("DateTimePicker").minDate(startDate);

        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);

        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
    $("#search_tran").click(function () {
        var fromDatetime = $("#toDate").val();
        var toDatetime = $("#fromDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
    });
    function resultSearchTransction(gamename, moneywin, moneylost, moneyother, fee, revenue, moneytotal) {
        var rs = "";
        rs += "<tr>";
        switch (gamename) {
            case 'Audition':
                rs += "<td>" + '<?php echo !empty($data) ? $data['Audition'] : '' ?>' + "</td>";
                break;
            case 'BENLEY':
                rs += "<td>" + '<?php echo !empty($data) ? $data['BENLEY'] : '' ?>' + "</td>";
                break;
            case 'BaCay':
                rs += "<td>" + '<?php echo !empty($data) ? $data['BaCay'] : '' ?>' + "</td>";
                break;
            case 'BauCua':
                rs += "<td>" + '<?php echo !empty($data) ? $data['BauCua'] : '' ?>' + "</td>";
                break;
            case 'CANDY':
                rs += "<td>" + '<?php echo !empty($data) ? $data['CANDY'] : '' ?>' + "</td>";
                break;
            case 'CaoThap':
                rs += "<td>" + '<?php echo !empty($data) ? $data['CaoThap'] : '' ?>' + "</td>";
                break;
            case 'Exchange':
                rs += "<td>" + '<?php echo !empty($data) ? $data['Exchange'] : '' ?>' + "</td>";
                break;
            case 'MAYBACH':
                rs += "<td>" + '<?php echo !empty($data) ? $data['MAYBACH'] : '' ?>' + "</td>";
                break;
            case 'MiniPoker':
                rs += "<td>" + '<?php echo !empty($data) ? $data['MiniPoker'] : '' ?>' + "</td>";
                break;
            case 'Spartan':
                rs += "<td>" + '<?php echo !empty($data) ? $data['Spartan'] : '' ?>' + "</td>";
                break;
            case 'TAMHUNG':
                rs += "<td>" + '<?php echo !empty($data) ? $data['TAMHUNG'] : '' ?>' + "</td>";
                break;
            case 'TaiXiu':
                rs += "<td>" + '<?php echo !empty($data) ? $data['TaiXiu'] : '' ?>' + "</td>";
                break;
            case 'Tlmn':
                rs += "<td>" + '<?php echo !empty($data) ? $data['Tlmn'] : '' ?>' + "</td>";
                break;
            case 'XocDia':
                rs += "<td>" + '<?php echo !empty($data) ? $data['XocDia'] : '' ?>' + "</td>";
                break;
            case 'ag':
                rs += "<td>" + '<?php echo !empty($data) ? $data['ag'] : '' ?>' + "</td>";
                break;
            case 'ibc':
                rs += "<td>" + '<?php echo !empty($data) ? $data['ibc'] : '' ?>' + "</td>";
                break;
            case 'wm':
                rs += "<td>" + '<?php echo !empty($data) ? $data['wm'] : '' ?>' + "</td>";
                break;
            case 'CHIEMTINH':
                rs += "<td>" + '<?php echo !empty($data) ? $data['CHIEMTINH'] : '' ?>' + "</td>";
                break;
            case 'TAI_XIU_ST':
                rs += "<td>" + '<?php echo !empty($data) ? $data['TAI_XIU_ST'] : '' ?>' + "</td>";
                break;
            case 'cmd':
                rs += "<td>" + '<?php echo !empty($data) ? $data['cmd'] : '' ?>' + "</td>";
                break;
            case 'ROLL_ROYE':
                rs += "<td>" + '<?php echo !empty($data) ? $data['ROLL_ROYE'] : '' ?>' + "</td>";
                break;
            case 'BIKINI':
                rs += "<td>" + '<?php echo !empty($data) ? $data['BIKINI'] : '' ?>' + "</td>";
                break;
            case 'GALAXY':
                rs += "<td>" + '<?php echo !empty($data) ? $data['GALAXY'] : '' ?>' + "</td>";
                break;
            case 'RANGE_ROVER':
                rs += "<td>" + '<?php echo !empty($data) ? $data['RANGE_ROVER'] : '' ?>' + "</td>";
                break;
            case 'FISH':
                rs += "<td>" + '<?php echo !empty($data) ? $data['FISH'] : '' ?>' + "</td>";
                break;
            case 'ebet':
                rs += "<td>" + '<?php echo !empty($data) ? $data['ebet'] : '' ?>' + "</td>";
                break;
            case 'sbo':
                rs += "<td>" + '<?php echo !empty($data) ? $data['sbo'] : '' ?>' + "</td>";
                break;
        }
        rs += "<td class='moneywinuser'>" + commaSeparateNumber(moneywin) + "</td>";
        rs += "<td class='moneylostuser'>" + commaSeparateNumber(moneylost) + "</td>";
        rs += "<td class='moneyotheruser'>" + commaSeparateNumber(moneyother) + "</td>";
        rs += "<td class='feeuser'>" + commaSeparateNumber(fee) + "</td>";
        rs += "<td class='revenueuser'>" + commaSeparateNumber(revenue) + "</td>";
        rs += "<td class='moneytotaluser'>" + commaSeparateNumber(moneytotal) + "</td>";
        rs += "</tr>";
        return rs;
    }
    function resulttotal(inuser, inevent, totalin, outuser, outagent, totalout, ratio) {

        var rs = "";
        rs += "<tr style='color: #0000ff'>";
        rs += "<td >" + commaSeparateNumber(inuser) + "</td>";
        rs += "<td>" + commaSeparateNumber(inevent) + "</td>";
        rs += "<td>" + commaSeparateNumber(totalin) + "</td>";
        rs += "<td>" + commaSeparateNumber(outuser) + "</td>";
        rs += "<td>" + commaSeparateNumber(outagent) + "</td>";
        rs += "<td>" + commaSeparateNumber(totalout) + "</td>";
        rs += "<td>" + ratio.toFixed(2) + "%" + "</td>";
        rs += "</tr>";
        return rs;
    }

    $(document).ready(function () {
        var result1 = "";
        var result2 = "";
        var result3 = "";
        $(".tabs-menu a").click(function (event) {
            event.preventDefault();
            $(this).parent().addClass("current");
            $(this).parent().siblings().removeClass("current");
            var tab = $(this).attr("href");
            $(".tab-content").not(tab).css("display", "none");
            $(tab).fadeIn();
        });
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/moneysystemajax  ')?>",
            // url: "http://192.168.0.251:8082/api_backend",
            data: {
                toDate: $("#toDate").val(),
                fromDate: $("#fromDate").val(),
            },

            dataType: 'json',
            success: function (res) {
                $("#spinner").hide();
                $("#resultsearch").html("");
                var total1 = 0;
                var total2 = 0;
                var total3 = 0;
                var total4 = 0;
                var total5 = 0;
                var total6 = 0;
                var total7 = 0;
                var total8 = 0;
                var total9 = 0;
                var total10 = 0;
                var total11 = 0;
                var total12 = 0;
                var total13 = 0;
                var total14 = 0;
                var total15 = 0;
                var total16 = 0;
                var total17 = 0;
                var total18 = 0;

                //Mini Game
                if (res.listReportSlotMiniGame != null || res.listReportSlotMiniGame != "") {
                    for (var i = 0; i < res.listReportSlotMiniGame.length; i++) {
                            if (res.listReportSlotMiniGame[i] != null) {
                                result1 += resultSearchTransction(res.listReportSlotMiniGame[i]['actionName'], res.listReportSlotMiniGame[i]['moneyWin'] , res.listReportSlotMiniGame[i]['moneyLost'], res.listReportSlotMiniGame[i]['moneyOther'], res.listReportSlotMiniGame[i]['fee'], res.listReportSlotMiniGame[i]['revenue'], res.listReportSlotMiniGame[i]['revenuePlayGame']);
                                $('#logaction1').html(result1);
                                total1 += res.listReportSlotMiniGame[i]['moneyWin'];
                                total2 += res.listReportSlotMiniGame[i]['moneyLost'];
                                total3 += res.listReportSlotMiniGame[i]['moneyOther'];
                                total4 += res.listReportSlotMiniGame[i]['fee'];
                                total5 += res.listReportSlotMiniGame[i]['revenue'];
                                total6 += res.listReportSlotMiniGame[i]['revenuePlayGame'];
                            }
                    }
                }

                $('#totalmoneywin').html(commaSeparateNumber(total1));
                $('#totalmoneylost').html(commaSeparateNumber(total2));
                $('#totalmoneyother').html(commaSeparateNumber(total3));
                $('#totalmoneyfee').html(commaSeparateNumber(total4));
                $('#totalmoneyplay').html(commaSeparateNumber(total5));
                $('#totalmoney').html(commaSeparateNumber(total6));

                //Game Bai
                if (res.listReportGameBai != null || res.listReportGameBai != "") {
                    for (var i = 0; i < res.listReportGameBai.length; i++) {
                        if (res.listReportGameBai[i] != null) {
                            result2 += resultSearchTransction(res.listReportGameBai[i]['actionName'], res.listReportGameBai[i]['moneyWin'] , res.listReportGameBai[i]['moneyLost'], res.listReportGameBai[i]['moneyOther'], res.listReportGameBai[i]['fee'], res.listReportGameBai[i]['revenue'], res.listReportGameBai[i]['revenuePlayGame']);
                            $('#logaction2').html(result2);
                            total7 += res.listReportGameBai[i]['moneyWin'];
                            total8 += res.listReportGameBai[i]['moneyLost'];
                            total9 += res.listReportGameBai[i]['moneyOther'];
                            total10 += res.listReportGameBai[i]['fee'];
                            total11 += res.listReportGameBai[i]['revenue'];
                            total12 += res.listReportGameBai[i]['revenuePlayGame'];
                        }
                    }
                }
                $('#totalmoneywinbai').html(commaSeparateNumber(total7));
                $('#totalmoneylostbai').html(commaSeparateNumber(total8));
                $('#totalmoneyotherbai').html(commaSeparateNumber(total9));
                $('#totalmoneyfeebai').html(commaSeparateNumber(total10));
                $('#totalmoneyplaybai').html(commaSeparateNumber(total11));
                $('#totalmoneybai').html(commaSeparateNumber(total12));

                //GAME KHAC
                if (res.listReportGameKhac != null || res.listReportGameKhac != "") {
                    for (var i = 0; i < res.listReportGameKhac.length; i++) {
                        if (res.listReportGameKhac[i] != null) {
                            result3 += resultSearchTransction(res.listReportGameKhac[i]['actionName'], res.listReportGameKhac[i]['moneyWin'] , res.listReportGameKhac[i]['moneyLost'], res.listReportGameKhac[i]['moneyOther'], res.listReportGameKhac[i]['fee'], res.listReportGameKhac[i]['revenue'], res.listReportGameKhac[i]['revenuePlayGame']);
                            $('#logaction3').html(result3);
                            total13 += res.listReportGameKhac[i]['moneyWin'];
                            total14 += res.listReportGameKhac[i]['moneyLost'];
                            total15 += res.listReportGameKhac[i]['moneyOther'];
                            total16 += res.listReportGameKhac[i]['fee'];
                            total17 += res.listReportGameKhac[i]['revenue'];
                            total18 += res.listReportGameKhac[i]['revenuePlayGame'];
                        }
                    }
                }
                $('#totalmoneywingame').html(commaSeparateNumber(total13));
                $('#totalmoneylostgame').html(commaSeparateNumber(total14));
                $('#totalmoneyothergame').html(commaSeparateNumber(total15));
                $('#totalmoneyfeegame').html(commaSeparateNumber(total16));
                $('#totalmoneyplaygame').html(commaSeparateNumber(total17));
                $('#totalmoneygame').html(commaSeparateNumber(total18));
                $('#summoneywin').html(commaSeparateNumber(total1 + total7 + total13));
                $('#summoneylost').html(commaSeparateNumber(total2 + total8 + total14));
                $('#summoneyother').html(commaSeparateNumber(total3 + total9 + total15));
                $('#summoneyfee').html(commaSeparateNumber(total4 + total10 + total16));
                $('#summoneyplay').html(commaSeparateNumber(total5 + total11 + total17));
                $('#summoney').html(commaSeparateNumber(total6 + total12 + total18));

                // Money in game
                var totalListUserIn = 0;
                var totalListUserInEvent = 0;
                var totalMoneyInGame = 0;
                for (var i=0; i < res.ListUserIn.length; i++ ){
                    $("#ListUserIn" + res.ListUserIn[i]['actionName']).html(commaSeparateNumber(res.ListUserIn[i]['total'] || 0));
                    totalListUserIn += res.ListUserIn[i]['total'] || 0;
                }
                $("#totalListUserIn").html(commaSeparateNumber(totalListUserIn || 0));

                let configList = ['GiftCode','GiftCodeVH','GiftCodeMKT','GcAgentImport','RefundFee','NhiemVu','EventVQMM','VQVIP','EventVP','CashoutByVP','BonusTopDS','EventVPBonus','KhoBauVqFree','NuDiepVienVqFree','SieuAnhHungVqFree','VuongQuocVinVqFree'];
                for (var j=0; j < res.ListUserInEvent.length; j++ ){
                    $("#ListUserInEvent" + res.ListUserInEvent[j]['actionName']).html(commaSeparateNumber(res.ListUserInEvent[j]['total'] || 0));
                    let check = configList.filter(word => word == res.ListUserInEvent[j]);
                    if(check.length) {
                        totalListUserInEvent += res.ListUserInEvent[j]['total'] || 0;
                    }
                }
                $("#totalListUserInEvent").html(commaSeparateNumber(totalListUserInEvent || 0));

                totalMoneyInGame = totalListUserIn + totalListUserInEvent;
                $("#totalMoneyInGame").html(commaSeparateNumber(totalMoneyInGame));

                // Money out game
                var totalListUserOut = 0;
                var totalAgency = 0;
                var totalMoneyOutGame = 0;
                var ratioCashout = 0;
                var total19 = 0;
                var total20 = 0;
                var resultLogactiontotal = "";
                configList = ['CashOutByClickPay','CashOutByPrincePay','CashOutByBank','RefundRechargeError'];
                for (var i=0; i < res.ListUserOut.length; i++ ){
                    $("#ListUserOut" + res.ListUserOut[i]['actionName']).html(commaSeparateNumber(res.ListUserOut[i]['total'] || 0));
                    let check = configList.filter(word => word == res.ListUserInEvent[j]);
                    if(check.length) {
                        totalListUserOut += res.ListUserOut[i]['total'] || 0;
                    }
                }

                $("#totalListUserOut").html(commaSeparateNumber(totalListUserOut || 0));
               //
                if (res.UserMoney['userStart'] != null || res.UserMoney['userStart'] != null) {
                    $("#UserMoneyuserStart").html(commaSeparateNumber(res.UserMoney['userStart']));
                    total19 =res.UserMoney['userStart'];
                } else {
                    $("#UserMoneyuserStart").html(0);
                }

                if (res.UserMoney['userEnd'] != null || res.UserMoney['userEnd'] != null) {
                    $("#UserMoneyuserEnd").html(commaSeparateNumber(res.UserMoney['userEnd']));
                    total20 =res.UserMoney['userEnd'];
                } else {
                    $("#UserMoneyuserEnd").html(0);
                }
                totalAgency = total20 - total19;
                totalMoneyOutGame = totalAgency + totalListUserOut;
                $('#UserMoney').html(commaSeparateNumber(totalAgency));
                $('#totalMoneyOut').html(commaSeparateNumber(totalMoneyOutGame));

                ratioCashout = totalMoneyOutGame / totalAgency;
                resultLogactiontotal += resulttotal(totalListUserIn, totalListUserInEvent, totalMoneyInGame, totalListUserOut, totalAgency, totalMoneyOutGame, ratioCashout);
                $('#logactiontotal').html(resultLogactiontotal);
            },
            error: function () {
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        })
    });
</script>
<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>
