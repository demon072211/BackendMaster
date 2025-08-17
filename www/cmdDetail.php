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
    <a class="" href="<?= admin_url('loggamethirdparty/cmd') . '?' . $uri?>">
        <i class="fas fa-angle-double-left"></i> Quay lại
    </a>
</div>
<div class="wrapper">
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <div class="title">
            <h6>Chi tiết loggame cmd</h6>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="background-sliver">id : </th>
                <td><?= isset($cmdItem) ? $cmdItem['id'] : '' ?></td>
                <th class="background-sliver">sourcename : </th>
                <td><?= isset($cmdItem) ? $cmdItem['sourcename'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">referenceno : </th>
                <td><?= isset($cmdItem) ? $cmdItem['referenceno'] : '' ?></td>
                <th class="background-sliver">soctransid : </th>
                <td><?= isset($cmdItem) ? $cmdItem['soctransid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">isfirsthalf : </th>
                <td><?= isset($cmdItem) ? $cmdItem['isfirsthalf'] : '' ?></td>
                <th class="background-sliver">transdate : </th>
                <td><?= isset($cmdItem) ?  date('Y/m/d H:i:s', $cmdItem['transdate'] / 1000000000) : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">ishomegive : </th>
                <td><?= isset($cmdItem) ? $cmdItem['ishomegive'] : '' ?></td>
                <th class="background-sliver">isbethome : </th>
                <td><?= isset($cmdItem) ? $cmdItem['isbethome'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">betamount : </th>
                <td><?= isset($cmdItem) ? $cmdItem['betamount'] : '' ?></td>
                <th class="background-sliver">outstanding : </th>
                <td><?= isset($cmdItem) ? $cmdItem['outstanding'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">hdp : </th>
                <td><?= isset($cmdItem) ? $cmdItem['hdp'] : '' ?></td>
                <th class="background-sliver">odds : </th>
                <td><?= isset($cmdItem) ? $cmdItem['odds'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">currency : </th>
                <td><?= isset($cmdItem) ? $cmdItem['currency'] : '' ?></td>
                <th class="background-sliver">winamount : </th>
                <td><?= isset($cmdItem) ? $cmdItem['winamount'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">exchangerate : </th>
                <td><?= isset($cmdItem) ? $cmdItem['exchangerate'] : '' ?></td>
                <th class="background-sliver">dangerstatus</th>
                <td><?= isset($cmdItem) ? $cmdItem['dangerstatus'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">memcommission : </th>
                <td><?= isset($cmdItem) ? $cmdItem['memcommission'] : '' ?></td>
                <th class="background-sliver">betip</th>
                <td><?= isset($cmdItem) ? $cmdItem['betip'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">homescore : </th>
                <td><?= isset($cmdItem) ? $cmdItem['homescore'] : '' ?></td>
                <th class="background-sliver">awayscore</th>
                <td><?= isset($cmdItem) ? $cmdItem['awayscore'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">runhomescore : </th>
                <td><?= isset($cmdItem) ? $cmdItem['runhomescore'] : '' ?></td>
                <th class="background-sliver">runawayscore</th>
                <td><?= isset($cmdItem) ? $cmdItem['runawayscore'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">isrunning : </th>
                <td><?= isset($cmdItem) ? $cmdItem['isrunning'] : '' ?></td>
                <th class="background-sliver">winlosestatus</th>
                <td><?= isset($cmdItem) ? $cmdItem['winlosestatus'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">sporttype : </th>
                <td><?= isset($cmdItem) ? $cmdItem['sporttype'] : '' ?></td>
                <th class="background-sliver">choice</th>
                <td><?= isset($cmdItem) ? $cmdItem['choice'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">workingdate : </th>
                <td><?= isset($cmdItem) ? $cmdItem['workingdate'] : '' ?></td>
                <th class="background-sliver">oddstype</th>
                <td><?= isset($cmdItem) ? $cmdItem['oddstype'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">matchdate : </th>
                <td><?= isset($cmdItem) ? date('Y/m/d H:i:s', $cmdItem['matchdate'] / 1000000000) : '' ?></td>
                <th class="background-sliver">hometeamid</th>
                <td><?= isset($cmdItem) ? $cmdItem['hometeamid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">awayteamid : </th>
                <td><?= isset($cmdItem) ? $cmdItem['awayteamid'] : '' ?></td>
                <th class="background-sliver">leagueid</th>
                <td><?= isset($cmdItem) ? $cmdItem['leagueid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">specialid : </th>
                <td><?= isset($cmdItem) ? $cmdItem['specialid'] : '' ?></td>
                <th class="background-sliver">statuschange</th>
                <td><?= isset($cmdItem) ? $cmdItem['statuschange'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">stateupdatets : </th>
                <td><?= isset($cmdItem) ? date('Y/m/d H:i:s', $cmdItem['stateupdatets'] / 1000000000) : '' ?></td>
                <th class="background-sliver">memcommissionset</th>
                <td><?= isset($cmdItem) ? $cmdItem['memcommissionset'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">iscashout : </th>
                <td><?= isset($cmdItem) ? $cmdItem['iscashout'] : '' ?></td>
                <th class="background-sliver">cashouttotal</th>
                <td><?= isset($cmdItem) ? $cmdItem['cashouttotal'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">cashouttakeback : </th>
                <td><?= isset($cmdItem) ? $cmdItem['cashouttakeback'] : '' ?></td>
                <th class="background-sliver">cashoutwinloseamount</th>
                <td><?= isset($cmdItem) ? $cmdItem['cashoutwinloseamount'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">betsource : </th>
                <td><?= isset($cmdItem) ? $cmdItem['betsource'] : '' ?></td>
                <th class="background-sliver">aosexcluding</th>
                <td><?= isset($cmdItem) ? $cmdItem['aosexcluding'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">mmrpercent : </th>
                <td><?= isset($cmdItem) ? $cmdItem['mmrpercent'] : '' ?></td>
                <th class="background-sliver">matchid</th>
                <td><?= isset($cmdItem) ? $cmdItem['matchid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">matchgroupid : </th>
                <td><?= isset($cmdItem) ? $cmdItem['matchgroupid'] : '' ?></td>
                <th class="background-sliver">betremarks</th>
                <td><?= isset($cmdItem) ? $cmdItem['betremarks'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">isspecial : </th>
                <td><?= isset($cmdItem) ? $cmdItem['isspecial'] : '' ?></td>
                <th class="background-sliver">betdate</th>
                <td><?= isset($cmdItem) ? $cmdItem['betdate'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">settleddate : </th>
                <td><?= isset($cmdItem) ? $cmdItem['settleddate'] : '' ?></td>
                <th class="background-sliver">loginname</th>
                <td><?= isset($cmdItem) ? $cmdItem['loginname'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">stake : </th>
                <td><?= isset($cmdItem) ? $cmdItem['stake'] : '' ?></td>
                <th class="background-sliver">payout</th>
                <td><?= isset($cmdItem) ? $cmdItem['payout'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">realbet : </th>
                <td><?= isset($cmdItem) ? $cmdItem['realbet'] : '' ?></td>

            </tr>

            </tbody>
        </table>
    </div>
</div>
<script>

</script>