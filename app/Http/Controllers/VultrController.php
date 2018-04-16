<?php

namespace App\Http\Controllers;

use App\Ip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Firewall;
use App\Helper\Response;

class VultrController extends Controller {
    public function index() {
        return view('vultr.index');
    }

    public function fireList(Request $request) {
        return Response::vultr(Firewall::request('GET', 'firewall/group_list'));
    }

    public function ruleList(Request $request) {
        return Response::vultr($this->formatRuleList(Firewall::request('GET', 'firewall/rule_list', [
            'FIREWALLGROUPID' => $request->input('fireid'),
            'direction'       => 'in',
            'ip_type'         => 'v4',
        ])));
    }

    public function ruleDelete(Request $request) {
        return Response::vultr(Firewall::request('POST', 'firewall/rule_delete', [], [
            'FIREWALLGROUPID' => $request->input('fireid'),
            'rulenumber'      => $request->input('rulenumber'),
        ]));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ruleAdd(Request $request) {
        $pm = \App\Helper\Request::validator($request->all(), [
            'protocol'    => 'bail|required|in:tcp,icmp,udp,gre',
            'subnet'      => 'bail|required|ip',
            'subnet_size' => 'bail|required|integer|max:32|min:0',
            'port'        => 'bail@',
            'fireid'      => 'bail|required',
        ]);

        return Response::vultr(Firewall::request('POST', 'firewall/rule_create', [], [
            'FIREWALLGROUPID' => $pm['fireid'],
            'direction'       => 'in',
            'ip_type'         => 'v4',
            'protocol'        => $pm['protocol'],
            'subnet'          => $pm['subnet'],
            'subnet_size'     => $pm['subnet_size'],
            'port'            => $pm['port'],
        ]));

    }

    public function user(Request $request) {
        return Response::vultr($request->user());
    }

    public function serverList() {
        $data = Firewall::request('GET', 'server/list');
        return ['data' => $data, 'display' => \json_encode($data)];
    }

    protected function formatRuleList($list) {
        if (is_array($list)) {
            $need_select = [];
            foreach ($list as $key => $value) {
                if ($value['subnet'] !== '0.0.0.0') {
                    $need_select[] = $value['subnet'];
                }
            }
            $need_select  = array_unique($need_select);
            $ip_mark_list = [];
            if (!empty($need_select)) {
                $ip_mark_list = Ip::whereIn('ip', $need_select)->get();

                foreach ($ip_mark_list as $key => $value) {
                    $ip_mark_list[$value->ip] = $value->remark;
                }
            }

            foreach ($list as $key => &$value) {
                $value['remark'] = '';
                if ($value['subnet'] !== '0.0.0.0' && isset($ip_mark_list[$value['subnet']])) {
                    $value['remark'] = $ip_mark_list[$value['subnet']];
                }

                $port = config('vultr.port');
                if (isset($port[$value['port']])) {
                    $value['remark'] = $value['remark'] . '(' . $port[$value['port']] . ')';
                }
            }

            return $list;
        }

        return $list;
    }
}
