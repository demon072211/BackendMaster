<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Log game bài</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper return-url">
    <a class="" href="<?= admin_url('loggamethirdparty/ag') . '?' . $uri?>">
        <i class="fas fa-angle-double-left"></i> Quay lại
    </a>
</div>
<div class="wrapper">
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <div class="title">
            <h6>Chi tiết loggame AG</h6>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="background-sliver">transid : </th>
                <td><?= isset($agItem) ? $agItem['transid'] : '' ?></td>
                <th class="background-sliver">playername : </th>
                <td><?= isset($agItem) ? $agItem['playername'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">transactiontime : </th>
                <td><?= isset($agItem) ? date('Y/m/d H:i:s', $agItem['transactiontime'] / 1000) : '' ?></td>
                <th class="background-sliver">matchid : </th>
                <td><?= isset($agItem) ? $agItem['matchid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">leagueid : </th>
                <td><?= isset($agItem) ? $agItem['leagueid'] : '' ?></td>
                <th class="background-sliver">leaguename : </th>
                <td><?= isset($agItem) ? $agItem['leaguename'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">awayid : </th>
                <td><?= isset($agItem) ? $agItem['awayid'] : '' ?></td>
                <th class="background-sliver">awayidname : </th>
                <td><?= isset($agItem) ? $agItem['awayidname'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">homeid : </th>
                <td><?= isset($agItem) ? $agItem['homeid'] : '' ?></td>
                <th class="background-sliver">homeidname : </th>
                <td><?= isset($agItem) ? $agItem['homeidname'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">matchdatetime : </th>
                <td><?= isset($agItem) ? date('Y/m/d H:i:s', $agItem['matchdatetime'] / 1000) : '' ?></td>
                <th class="background-sliver">bettype : </th>
                <td><?= isset($agItem) ? $agItem['bettype'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">parlayrefno : </th>
                <td><?= isset($agItem) ? $agItem['parlayrefno'] : '' ?></td>
                <th class="background-sliver">betteam : </th>
                <td><?= isset($agItem) ? $agItem['betteam'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">hdp : </th>
                <td><?= isset($agItem) ? $agItem['betteam'] : '' ?></td>
                <th class="background-sliver">sporttype</th>
                <td><?= isset($agItem) ? $agItem['sporttype'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    awayhdp :
                </th>
                <td><?= isset($agItem) ? $agItem['awayhdp'] : '' ?></td>
                <th class="background-sliver2">
                    homehdp
                </th>
                <td><?= isset($agItem) ? $agItem['homehdp'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    awayscore
                </th>
                <td><?= isset($agItem) ? $agItem['awayscore'] : '' ?></td>
                <th>homescore</th>
                <td><?= isset($agItem) ? $agItem['homescore'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    islive
                </th>
                <td><?= isset($agItem) ? $agItem['islive'] : '' ?></td>
                <th>islucky</th>
                <td><?= isset($agItem) ? $agItem['islucky'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    parlay_type
                </th>
                <td><?= isset($agItem) ? $agItem['parlay_type'] : '' ?></td>
                <th>combo_type</th>
                <td><?= isset($agItem) ? $agItem['combo_type'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    stake
                </th>
                <td><?= isset($agItem) ? $agItem['stake'] : '' ?></td>
                <th>bettag</th>
                <td><?= isset($agItem) ? $agItem['bettag'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    winloseamount
                </th>
                <td><?= isset($agItem) ? $agItem['winloseamount'] : '' ?></td>
                <th>winlostdatetime</th>
                <td><?= isset($agItem) ? date('Y/m/d H:i:s', $agItem['winlostdatetime'] / 1000) : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    versionkey
                </th>
                <td><?= isset($agItem) ? $agItem['versionkey'] : '' ?></td>
                <th>lastballno</th>
                <td><?= isset($agItem) ? $agItem['lastballno'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    ticketstatus
                </th>
                <td><?= isset($agItem) ? $agItem['ticketstatus'] : '' ?></td>
                <th>oddstype</th>
                <td><?= isset($agItem) ? $agItem['oddstype'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    actual_stake
                </th>
                <td><?= isset($agItem) ? $agItem['actual_stake'] : '' ?></td>
                <th>refund_amount</th>
                <td><?= isset($agItem) ? $agItem['refund_amount'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver2">
                    nick_name
                </th>
                <td><?= isset($agItem) ? $agItem['nick_name'] : '' ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>

</script>
