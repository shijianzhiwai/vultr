<?php

namespace App\Http\Controllers;

use App\Ip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Firewall;
use App\Helper\Response;

class VultrController extends Controller
{
    public function index()
    {
        return view('vultr.index');
    }

    public function fireList(Request $request)
    {
        return Response::vultr(Firewall::request('GET','firewall/group_list'));
    }

    public function ruleList(Request $request)
    {
        return Response::vultr($this->formatRuleList(Firewall::request('GET','firewall/rule_list', [
            'FIREWALLGROUPID' => $request->input('fireid'),
            'direction' => 'in',
            'ip_type' => 'v4',
        ])));
    }

    public function user(Request $request)
    {
        return Response::vultr($request->user());
    }

    public function createIp(Request $request)
    {
        $this->validate($request, [
            'ip' => 'required|unique:ip|ipv4',
            'remark' => 'required|max:100',
        ]);
    }

    protected function formatRuleList($list)
    {
        if (is_array($list)) {
            $need_select = [];
            foreach ($list as $key => $value) {
                if ($value['subnet'] !== '0.0.0.0') {
                    $need_select[] = $value['subnet'];
                }
            }
            $need_select = array_unique($need_select);
            $ip_mark_list =[];
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
