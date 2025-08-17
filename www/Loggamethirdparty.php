	<?php
	Class Loggamethirdparty extends MY_Controller
	{
			function __construct()
			{
					parent::__construct();

			}

			function ag()
			{
					canMenu('loggamethirdparty/ag');
					$this->data['temp'] = 'admin/loggamethirdparty/ag';
					$this->load->view('admin/main', $this->data);
			}

            public function agDetail()
            {
                canMenu('loggamethirdparty/ag');
                $billNo = $this->uri->rsegment(3);
                if (empty($billNo)) {
                    return redirect(admin_url('loggamethirdparty/ag'));
                }
                $params = [
                    'c' => 9310,
                    'bn' => $billNo,
                ];
                $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);

                $queries = [
                    'flagtime' => $this->input->get('flagtime'),
                    'billNo' => $this->input->get('billNo'),
                    'fromDate' => $this->input->get('fromDate'),
                    'toDate' => $this->input->get('toDate'),
                    'gameType' => $this->input->get('gameType'),
                    'bet' => $this->input->get('bet'),
                    'nickName' => $this->input->get('nickName'),
                    'payOut' => $this->input->get('payOut'),
                    'gameCode' => $this->input->get('gameCode'),
                    'betIp' => $this->input->get('betIp'),
                    'username' => $this->input->get('username'),
                    'maxItem' => $this->input->get('maxItem'),
                ];
                $this->data['uri'] = http_build_query($queries);
                try {
                    $response = $this->get_data_curl($endPoint);
                    if (empty($response)) {
                        return redirect(admin_url('loggamethirdparty/ag'));
                    }
                    $data = json_decode($response, true);
                    if (empty($data['data'][0])) {
                        return redirect(admin_url('loggamethirdparty/ag'));
                    }
                    $this->data['agItem'] = $data['data'][0];
                    $this->data['temp'] = 'admin/loggamethirdparty/agDetail';
                    $this->load->view('admin/main', $this->data);
                } catch (\Exception $e) {
                    return redirect(admin_url('loggamethirdparty/ag'));
                }
            }

			function agajax()
			{
					canMenu('loggamethirdparty/ag');
					$nickName = urlencode($this->input->post("nickName"));
					$billNo = urlencode($this->input->post("billNo"));
					$gameCode = urlencode($this->input->post("gameCode"));
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$flagTime = urlencode($this->input->post("flagTime"));
					$gameType = urlencode($this->input->post("gameType"));
					$bet = urlencode($this->input->post("bet"));
					$payOut = urlencode($this->input->post("payOut"));
					$betIp = urlencode($this->input->post("betIp"));
                    $username = urlencode($this->input->post("username"));
					$page = urlencode($this->input->post("page"));
					$maxItem = urlencode($this->input->post("maxItem"));
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=9301&un='.$username. '&nn='.$nickName. '&bn='.$billNo. '&gc='.$gameCode
							. '&ft=' . urlencode($fromDate) . '&et=' . urlencode($toDate).'&gt='.$gameType. '&flt=' .$flagTime. '&ba='.$bet. '&wa='.$payOut. '&bi='.$betIp . '&pg='.$page. '&mi='.$maxItem);
 					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function ibc()
			{
					canMenu('loggamethirdparty/ibc');
					$this->data['temp'] = 'admin/loggamethirdparty/ibc';
					$this->load->view('admin/main', $this->data);
			}

            function ibcDetail() {
                canMenu('loggamethirdparty/ibc');
                $trid = $this->uri->rsegment(3);
                if (empty($trid)) {
                    return redirect(admin_url('loggamethirdparty/ibc'));
                }
                $params = [
                    'c' => 9310,
                    'trid' => $trid,
                ];
                $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);

                $queries = [
                    "flagtime" => $this->input->get("maxItem"),
                    "refundamount" => $this->input->get("refundamount"),
                    "fromDate" => $this->input->get("fromDate"),
                    "toDate" => $this->input->get("toDate"),
                    "ticketstatus" => $this->input->get("ticketstatus"),
                    "transid" => $this->input->get("transid"),
                    "matchid" => $this->input->get("matchid"),
                    "homeid" => $this->input->get("homeid"),
                    "stake" => $this->input->get("stake"),
                    "winloseamount" => $this->input->get("winloseamount"),
                    "nickName" => $this->input->get("nickName"),
                    "playername" => $this->input->get("playername"),
                    "maxItem" => $this->input->get("maxItem"),
                ];
                $this->data['uri'] = http_build_query($queries);
                try {
                    $response = $this->get_data_curl($endPoint);
                    if (empty($response)) {
                        return redirect(admin_url('loggamethirdparty/ibc'));
                    }
                    $data = json_decode($response, true);
                    if (empty($data['data'][0])) {
                        return redirect(admin_url('loggamethirdparty/ibc'));
                    }
                    $this->data['ibcItem'] = $data['data'][0];
                    $this->data['temp'] = 'admin/loggamethirdparty/ibcDetail';
                    $this->load->view('admin/main', $this->data);
                } catch (\Exception $e) {
                    return redirect(admin_url('loggamethirdparty/ibc'));
                }
            }

			function ibcajax()
			{
					canMenu('loggamethirdparty/ibc');
					$nickName = urlencode($this->input->post("nickName"));
					$playerName = urlencode($this->input->post("playerName"));
					$ticketStatus = urlencode($this->input->post("ticketStatus"));
					$transID = urlencode($this->input->post("transID"));
					$matchID = urlencode($this->input->post("matchID"));
					$homeID = urlencode($this->input->post("homeID"));
					$stake = urlencode($this->input->post("stake"));
					$winloseAmount = urlencode($this->input->post("winloseAmount"));
					$refundAmount = urlencode($this->input->post("refundAmount"));
					$toDate = urlencode($this->input->post("toDate"));
					$fromDate = urlencode($this->input->post("fromDate"));
					$flagTime = urlencode($this->input->post("flagTime"));
					$page = urlencode($this->input->post("page"));
					$maxItem = urlencode($this->input->post("maxItem"));
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=9300&nn='.$nickName. '&pn='.$playerName. '&tt='.$ticketStatus
							. '&trid=' . $transID . '&mid=' . $matchID.'&hid='.$homeID.'&sk='.$stake. '&wa='.$winloseAmount
							. '&ra='.$refundAmount. '&ft=' .$fromDate. '&et=' .$toDate. '&fgt=' .$flagTime. '&pg='.$page. '&mi='.$maxItem);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function wm()
			{
					canMenu('loggamethirdparty/wm');
					$this->data['temp'] = 'admin/loggamethirdparty/wm';
					$this->load->view('admin/main', $this->data);
			}

        public function wmDetail()
        {
            canMenu('loggamethirdparty/wm');
            $bid = $this->uri->rsegment(3);
            if (empty($bid)) {
                return redirect(admin_url('loggamethirdparty/wm'));
            }
            $params = [
                'c' => 9312,
                'bid' => $bid,
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            $queries = [
                'flagtime' => $this->input->get("flagtime"),
                'nickName' => $this->input->get("nickName"),
                'fromDate' => $this->input->get("fromDate"),
                'toDate' => $this->input->get("toDate"),
                'userId' => $this->input->get("userId"),
                'betId' => $this->input->get("betId"),
                'gameName' => $this->input->get("gameName"),
                'userIp' => $this->input->get("userIp"),
                'maxItem' => $this->input->get("maxItem"),
            ];
            $this->data['uri'] = http_build_query($queries);
            try {
                $response = $this->get_data_curl($endPoint);
                if (empty($response)) {
                    return redirect(admin_url('loggamethirdparty/wm'));
                }
                $data = json_decode($response, true);
                if (empty($data['data'][0])) {
                    return redirect(admin_url('loggamethirdparty/wm'));
                }
                $this->data['wmItem'] = $data['data'][0];
                $this->data['temp'] = 'admin/loggamethirdparty/wmDetail';
                $this->load->view('admin/main', $this->data);
            } catch (\Exception $e) {
                return redirect(admin_url('loggamethirdparty/wm'));
            }
        }

			function wmajax()
			{
					canMenu('loggamethirdparty/wm');
					$nickName = urlencode($this->input->post("nickName"));
					$userId = urlencode($this->input->post("userId"));
					$betId = urlencode($this->input->post("betId"));
					$userIp = urlencode($this->input->post("userIp"));
					$gameName = urlencode($this->input->post("gameName"));
					$toDate = urlencode($this->input->post("toDate"));
					$fromDate = urlencode($this->input->post("fromDate"));
					$flagTime = urlencode($this->input->post("flagTime"));
					$page = urlencode($this->input->post("page"));
					$maxItem = urlencode($this->input->post("maxItem"));
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=9302&nn='.$nickName. '&us='.$userId. '&ip='.$userIp
							. '&gn=' .$gameName. '&ft=' .$fromDate. '&et=' .$toDate. '&bid=' .$betId. '&fgt=' .$flagTime. '&pg=' .$page. '&mi='.$maxItem);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

        function cmd()
        {
            canMenu('loggamethirdparty/cmd');
            $this->data['temp'] = 'admin/loggamethirdparty/cmd';
            $this->load->view('admin/main', $this->data);
        }

        function cmdajax()
        {
            canMenu('loggamethirdparty/cmd');
            $data = [
                'c' => 9304,
                'rn' => $this->input->post("rn"),
                'sn' => $this->input->post("sn"),
                'ln' => $this->input->post("ln"),
                'fgt' => $this->input->post("fgt"),
                'ft' => $this->input->post("ft"),
                'et' => $this->input->post("et"),
                'pg' => $this->input->post("page"),
                'mi' => $this->input->post("maxItem"),
            ];
            $endPoint = $this->config->item('api_backend') . '?' . http_build_query($data);
            $data = $this->get_data_curl($endPoint);
            if (isset($data)) {
                echo $data;
                return;
            }
            echo "Bạn không được hack";
            return;
        }

        public function cmdDetail()
        {
            canMenu('loggamethirdparty/cmd');
            $id = $this->uri->rsegment(3);
            if (empty($id)) {
                return redirect(admin_url('loggamethirdparty/cmd'));
            }
            $params = [
                'c' => 9313 ,
                'id' => $id,
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);

            $queries = [
                'referenceno' => $this->input->get("referenceno"),
                'sourcename' => $this->input->get("sourcename"),
                'fromDate' => $this->input->get("fromDate"),
                'toDate' => $this->input->get("toDate"),
                'betip' => $this->input->get("betip"),
                'loginname' => $this->input->get("loginname"),
                'fgt' => $this->input->get("fgt"),
            ];
            $this->data['uri'] = http_build_query($queries);
            try {
                $response = $this->get_data_curl($endPoint);
                if (empty($response)) {
                    return redirect(admin_url('loggamethirdparty/cmd'));
                }
                $data = json_decode($response, true);
                if (empty($data['data'][0])) {
                    return redirect(admin_url('loggamethirdparty/cmd'));
                }
                $this->data['cmdItem'] = $data['data'][0];
                $this->data['temp'] = 'admin/loggamethirdparty/cmdDetail';
                $this->load->view('admin/main', $this->data);
            } catch (\Exception $e) {
                return redirect(admin_url('loggamethirdparty/cmd'));
            }
        }

        function fish()
        {
            canMenu('loggamethirdparty/fish');
            $this->data['temp'] = 'admin/loggamethirdparty/fish';
            $this->load->view('admin/main', $this->data);
        }

        function fishAjax()
        {
            canMenu('loggamethirdparty/fish');
            $params = [
                'c' => 9434 ,
                'nn' => $this->input->post("nn"),
                'ft' => $this->input->post("ft"),
                'et' => $this->input->post("et"),
                'pg' => $this->input->post("pg"),
                'mi' => $this->input->post("size"),
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                if (isset($data)) {
                    echo $data;
                    return;
                }
                echo "Bạn không được hack";
                return;

            } catch (\Exception $e) {
                log_message('error', 'Caught exception fishAjax : ' . $e->getMessage());
                return;
            }
        }

        function sbo()
        {
            canMenu('loggamethirdparty/sbo');
            $this->data['temp'] = 'admin/loggamethirdparty/sbo';
            $this->load->view('admin/main', $this->data);
        }

        function sboAjax()
        {
            canMenu('loggamethirdparty/sbo');
            $params = [
                'c' => 9435 ,
                'nn' => $this->input->post("nn"),
                'ft' => $this->input->post("ft"),
                'et' => $this->input->post("et"),
                'pg' => $this->input->post("pg"),
                'mi' => $this->input->post("size"),
                'flagTime' => 1,
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                if (isset($data)) {
                    echo $data;
                    return;
                }
                echo "Bạn không được hack";
                return;
            } catch (\Exception $e) {
                log_message('error', 'Caught exception sboAjax : ' . $e->getMessage());
                return;
            }
        }

        function ebet()
        {
            canMenu('loggamethirdparty/ebet');
            $this->data['temp'] = 'admin/loggamethirdparty/ebet';
            $this->load->view('admin/main', $this->data);
        }

        function ebetAjax()
        {
            canMenu('loggamethirdparty/ebet');
            $params = [
                'c' => 9438 ,
                'nn' => $this->input->post("nn"),
                'ft' => $this->input->post("fromDate"),
                'et' => $this->input->post("toDate"),
                'pg' => $this->input->post("pg") ?? 1,
                'mi' => $this->input->post("size") ?? 10,
                'flt' => $this->input->post("fgt"),
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                echo empty($data) ? '' : $data;
                return;
            } catch (\Exception $e) {
                log_message('error', 'Caught exception sboAjax : ' . $e->getMessage());
                return;
            }
        }
	}