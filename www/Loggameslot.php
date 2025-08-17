	<?php
	Class Loggameslot extends MY_Controller
	{
			function __construct()
			{
					parent::__construct();

			}

			function chimdien()
			{
					canMenu('loggameslot/chimdien');
					$this->data['temp'] = 'admin/loggameslot/chimdien';
					$this->load->view('admin/main', $this->data);
			}

			function chimdienajax()
			{
					canMenu('loggameslot/chimdien');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$page = urlencode($this->input->post("page"));
					$gametype = 160;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value
							. '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate).'&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function crypto()
			{
					canMenu('loggameslot/crypto');
					$this->data['temp'] = 'admin/loggameslot/crypto';
					$this->load->view('admin/main', $this->data);
			}

			function cryptoajax()
			{
					canMenu('loggameslot/crypto');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$page = urlencode($this->input->post("page"));
					$gametype = 170;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value
							. '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate).'&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function kimbinhmai()
			{
					canMenu('loggameslot/kimbinhmai');
					$this->data['temp'] = 'admin/loggameslot/kimbinhmai';
					$this->load->view('admin/main', $this->data);
			}

			function kimbinhmaiajax()
			{
					canMenu('loggameslot/kimbinhmai');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$page = urlencode($this->input->post("page"));
					$gametype = 1;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value
							. '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate).'&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function pokemon()
			{
					canMenu('loggameslot/pokemon');
					$this->data['temp'] = 'admin/loggameslot/pokemon';
					$this->load->view('admin/main', $this->data);
			}

			function pokemonajax()
			{
					canMenu('loggameslot/pokemon');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = urlencode($this->input->post("toDate"));
					$fromDate = urlencode($this->input->post("fromDate"));
					$page = urlencode($this->input->post("page"));
					$gametype = 6;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value . '&ts=' .$fromDate . '&te=' . $toDate. '&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function taydu()
			{
					canMenu('loggameslot/taydu');
					$this->data['temp'] = 'admin/loggameslot/taydu';
					$this->load->view('admin/main', $this->data);
			}

			function tayduajax()
			{
					canMenu('loggameslot/taydu');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$page = urlencode($this->input->post("page"));
					$gametype = 110;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value
							. '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate).'&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function thantai()
			{
					canMenu('loggameslot/thantai');
					$this->data['temp'] = 'admin/loggameslot/thantai';
					$this->load->view('admin/main', $this->data);
			}

			function thantaiajax()
			{
					canMenu('loggameslot/thantai');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$page = urlencode($this->input->post("page"));
					$gametype = 120;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value
							. '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate).'&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

			function thethao()
			{
					canMenu('loggameslot/thethao');
					$this->data['temp'] = 'admin/loggameslot/thethao';
					$this->load->view('admin/main', $this->data);
			}

			function thethaoajax()
			{
					canMenu('loggameslot/thethao');
					$nickName = urlencode($this->input->post("nickName"));
					$transId = urlencode($this->input->post("transId"));
					$bet_value = $this->input->post("bet_value");
					$toDate = $this->input->post("toDate");
					$fromDate = $this->input->post("fromDate");
					$page = urlencode($this->input->post("page"));
					$gametype = 150;
					$datainfo = $this->get_data_curl($this->config->item('api_backend').'?c=516&nn='.$nickName. '&tid='.$transId. '&r='.$bet_value
							. '&ts=' . urlencode($fromDate) . '&te=' . urlencode($toDate).'&gameType='.$gametype.'&p='.$page);
					if(isset($datainfo)) {
							echo $datainfo;
					}else{
							echo "Bạn không được hack";
					}
			}

        function chiemtinh()
        {
            canMenu('loggameslot/chiemtinh');
            $this->data['temp'] = 'admin/loggameslot/chiemtinh';
            $this->load->view('admin/main', $this->data);
        }

        function chiemtinhajax()
        {
            canMenu('loggameslot/chiemtinh');
            $params = [
                'c' => 516,
                'nn' => $this->input->post("nickName"),
                'tid' => $this->input->post("transId"),
                'r' => $this->input->post("bet_value"),
                'ts' => $this->input->post("fromDate"),
                'te' => $this->input->post("toDate"),
                'gameType' => 191,
                'p' => $this->input->post("page"),
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                echo empty($data) ? "Bạn không được hack" : $data;
                return;
            } catch (\Exception $e) {
                log_message('error', 'Caught exception getListAjax : ' . $e->getMessage());
                return;
            }
        }

        function bikini()
        {
            canMenu('loggameslot/bikini');
            $this->data['temp'] = 'admin/loggameslot/bikini';
            $this->load->view('admin/main', $this->data);
        }

        function bikiniAjax()
        {
            canMenu('loggameslot/bikini');
            $params = [
                'c' => 516,
                'nn' => $this->input->post("nickName"),
                'tid' => $this->input->post("transId"),
                'r' => $this->input->post("bet_value"),
                'ts' => $this->input->post("fromDate"),
                'te' => $this->input->post("toDate"),
                'gameType' => 197,
                'p' => $this->input->post("page"),
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                echo empty($data) ? "Bạn không được hack" : $data;
                return;
            } catch (\Exception $e) {
                log_message('error', 'Caught exception getListAjax : ' . $e->getMessage());
                return;
            }
        }

        function thanbai()
        {
            canMenu('loggameslot/thanbai');
            $this->data['temp'] = 'admin/loggameslot/thanbai';
            $this->load->view('admin/main', $this->data);
        }

        function thanbaiAjax()
        {
            canMenu('loggameslot/thanbai');
            $params = [
                'c' => 516,
                'nn' => $this->input->post("nickName"),
                'tid' => $this->input->post("transId"),
                'r' => $this->input->post("bet_value"),
                'ts' => $this->input->post("fromDate"),
                'te' => $this->input->post("toDate"),
                'gameType' => 180,
                'p' => $this->input->post("page"),
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                echo empty($data) ? "Bạn không được hack" : $data;
                return;
            } catch (\Exception $e) {
                log_message('error', 'Caught exception getListAjax : ' . $e->getMessage());
                return;
            }
        }

        function galaxy()
        {
            canMenu('loggameslot/galaxy');
            $this->data['temp'] = 'admin/loggameslot/galaxy';
            $this->load->view('admin/main', $this->data);
        }

        function galaxyAjax()
        {
            canMenu('loggameslot/galaxy');
            $params = [
                'c' => 516,
                'nn' => $this->input->post("nickName"),
                'tid' => $this->input->post("transId"),
                'r' => $this->input->post("bet_value"),
                'ts' => $this->input->post("fromDate"),
                'te' => $this->input->post("toDate"),
                'gameType' => 198,
                'p' => $this->input->post("page"),
            ];
            $endPoint = $this->config->item('api_backend') . "?" . http_build_query($params);
            try {
                $data = $this->get_data_curl($endPoint);
                echo empty($data) ? "Bạn không được hack" : $data;
                return;
            } catch (\Exception $e) {
                log_message('error', 'Caught exception getListAjax : ' . $e->getMessage());
                return;
            }
        }
	}