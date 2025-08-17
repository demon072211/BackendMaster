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
    <a class="" href="<?= admin_url('loggamethirdparty/wm') . "?" . $uri?>">
        <i class="fas fa-angle-double-left"></i> Quay lại
    </a>
</div>
<div class="wrapper">
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <div class="title">
            <h6>Chi tiết loggame WM</h6>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="background-sliver">betid : </th>
                <td><?= isset($wmItem) ? $wmItem['betid'] : '' ?></td>
                <th class="background-sliver">loginname : </th>
                <td><?= isset($wmItem) ? $wmItem['loginname'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">user : </th>
                <td><?= isset($wmItem) ? $wmItem['user'] : '' ?></td>
                <th class="background-sliver">bettime : </th>
                <td><?= isset($wmItem) ? $wmItem['bettime'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">settime : </th>
                <td><?= isset($wmItem) ? $wmItem['settime'] : '' ?></td>
                <th class="background-sliver">rootbettime : </th>
                <td><?= isset($wmItem) ? $wmItem['rootbettime'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">rootsettime : </th>
                <td><?= isset($wmItem) ? $wmItem['rootsettime'] : '' ?></td>
                <th class="background-sliver">bet : </th>
                <td><?= isset($wmItem) ? $wmItem['bet'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">validbet : </th>
                <td><?= isset($wmItem) ? $wmItem['validbet'] : '' ?></td>
                <th class="background-sliver">winloss : </th>
                <td><?= isset($wmItem) ? $wmItem['winloss'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">water : </th>
                <td><?= isset($wmItem) ? $wmItem['water'] : '' ?></td>
                <th class="background-sliver">waterbet : </th>
                <td><?= isset($wmItem) ? $wmItem['waterbet'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">result : </th>
                <td><?= isset($wmItem) ? $wmItem['result'] : '' ?></td>
                <th class="background-sliver">betcode : </th>
                <td><?= isset($wmItem) ? $wmItem['betcode'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">betresult : </th>
                <td><?= isset($wmItem) ? $wmItem['betresult'] : '' ?></td>
                <th class="background-sliver">gameid : </th>
                <td><?= isset($wmItem) ? $wmItem['gameid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">ip : </th>
                <td><?= isset($wmItem) ? $wmItem['ip'] : '' ?></td>
                <th class="background-sliver">event : </th>
                <td><?= isset($wmItem) ? $wmItem['event'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">eventchild : </th>
                <td><?= isset($wmItem) ? $wmItem['eventchild'] : '' ?></td>
                <th class="background-sliver">tableid : </th>
                <td><?= isset($wmItem) ? $wmItem['tableid'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">gameresult : </th>
                <td><?= isset($wmItem) ? $wmItem['gameresult'] : '' ?></td>
                <th class="background-sliver">gamename : </th>
                <td><?= isset($wmItem) ? $wmItem['gamename'] : '' ?></td>
            </tr>
            <tr>
                <th class="background-sliver">commission : </th>
                <td><?= isset($wmItem) ? $wmItem['commission'] : '' ?></td>
                <th class="background-sliver">reset : </th>
                <td><?= isset($wmItem) ? $wmItem['reset'] : '' ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>

</script>
