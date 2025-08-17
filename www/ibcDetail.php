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
    <a class="" href="<?= admin_url('loggamethirdparty/ibc') . '?' . $uri?>">
        <i class="fas fa-angle-double-left"></i> Quay lại
    </a>
</div>
<div class="wrapper">
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <div class="title">
            <h6>Chi tiết loggame IBC</h6>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="background-sliver">transid : </th>
                <td><?= isset($ibcItem) ? $ibcItem['transid'] : '' ?></td>
                <th class="background-sliver">playername : </th>
                <td><?= isset($ibcItem) ? $ibcItem['playername'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">transactiontime : </th>
                <td><?= isset($ibcItem) ? date('Y/m/d H:i:s', $ibcItem['transactiontime'] / 1000) : '' ?></td>
                <th class="background-sliver">matchid : </th>
                <td><?= isset($ibcItem) ? $ibcItem['matchid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">leagueid : </th>
                <td><?= isset($ibcItem) ? $ibcItem['leagueid'] : '' ?></td>
                <th class="background-sliver">leaguename : </th>
                <td><?= isset($ibcItem) ? $ibcItem['leaguename'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">awayid : </th>
                <td><?= isset($ibcItem) ? $ibcItem['awayid'] : '' ?></td>
                <th class="background-sliver">awayidname : </th>
                <td><?= isset($ibcItem) ? $ibcItem['awayidname'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">homeid : </th>
                <td><?= isset($ibcItem) ? $ibcItem['homeid'] : '' ?></td>
                <th class="background-sliver">homeidname : </th>
                <td><?= isset($ibcItem) ? $ibcItem['homeidname'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">matchdatetime : </th>
                <td><?= isset($ibcItem) ? date('Y/m/d H:i:s', $ibcItem['matchdatetime'] / 1000) : '' ?></td>
                <th class="background-sliver">bettype : </th>
                <td><?= isset($ibcItem) ? $ibcItem['bettype'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">parlayrefno : </th>
                <td><?= isset($ibcItem) ? $ibcItem['parlayrefno'] : '' ?></td>
                <th class="background-sliver">betteam : </th>
                <td><?= isset($ibcItem) ? $ibcItem['betteam'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">hdp : </th>
                <td><?= isset($ibcItem) ? $ibcItem['hdp'] : '' ?></td>
                <th class="background-sliver">sporttype : </th>
                <td><?= isset($ibcItem) ? $ibcItem['sporttype'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">awayhdp : </th>
                <td><?= isset($ibcItem) ? $ibcItem['awayhdp'] : '' ?></td>
                <th class="background-sliver">homehdp : </th>
                <td><?= isset($ibcItem) ? $ibcItem['homehdp'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">odds : </th>
                <td><?= isset($ibcItem) ? $ibcItem['odds'] : '' ?></td>
                <th class="background-sliver">awayscore : </th>
                <td><?= isset($ibcItem) ? $ibcItem['awayscore'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">homescore : </th>
                <td><?= isset($ibcItem) ? $ibcItem['homescore'] : '' ?></td>
                <th class="background-sliver">islive : </th>
                <td><?= isset($ibcItem) ? $ibcItem['islive'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">islucky : </th>
                <td><?= isset($ibcItem) ? $ibcItem['islucky'] : '' ?></td>
                <th class="background-sliver">parlay_type : </th>
                <td><?= isset($ibcItem) ? $ibcItem['parlay_type'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">combo_type : </th>
                <td><?= isset($ibcItem) ? $ibcItem['combo_type'] : '' ?></td>
                <th class="background-sliver">stake : </th>
                <td><?= isset($ibcItem) ? $ibcItem['stake'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">bettag : </th>
                <td><?= isset($ibcItem) ? $ibcItem['bettag'] : '' ?></td>
                <th class="background-sliver">winloseamount : </th>
                <td><?= isset($ibcItem) ? $ibcItem['winloseamount'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">winlostdatetime : </th>
                <td><?= isset($ibcItem) ? date('Y/m/d H:i:s', $ibcItem['winlostdatetime'] / 1000) : '' ?></td>
                <th class="background-sliver">versionkey : </th>
                <td><?= isset($ibcItem) ? $ibcItem['versionkey'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">lastballno : </th>
                <td><?= isset($ibcItem) ? $ibcItem['lastballno'] : '' ?></td>
                <th class="background-sliver">ticketstatus : </th>
                <td><?= isset($ibcItem) ? $ibcItem['ticketstatus'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">oddstype : </th>
                <td><?= isset($ibcItem) ? $ibcItem['oddstype'] : '' ?></td>
                <th class="background-sliver">actual_stake : </th>
                <td><?= isset($ibcItem) ? $ibcItem['actual_stake'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">refund_amount : </th>
                <td><?= isset($ibcItem) ? $ibcItem['refund_amount'] : '' ?></td>
                <th class="background-sliver">nick_name : </th>
                <td><?= isset($ibcItem) ? $ibcItem['nick_name'] : '' ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>

</script>
