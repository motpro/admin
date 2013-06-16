<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_client.php 10000 2013-03-06 mot $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
session_start();

require_once libfile('function/delete');
    cpheader();


    define('M2S' , 2592000);
    //每页显示结果数
    define('PAGENUM' , '20');
    //用户类型
    define('PRIVATE' , 0);
    define('SINGLE' , 0);
    define('CORPORATION' ,1);
    //订单类型
    define('REQUIREMENT' , 0);
    define('ONLINE' , 1);
    define('OFFLINE' , 2);
    //支付方式
    define('ONLINE_PAY' , 0);
    define('OFFLINE_PAY' , 1);
    //订单状态
    define('ALL' , 0);
    define('NOPAYMENT' , 1);
    define('PENDDING', 2);
    define('RECEIPT' , 3);
    define('NOCONFIRM',4);
    define('CANCEL' , 5);

    define('ALREADY' , 1);
    define('NOTRECEIPT' , 2);
    define('WAITRECEIPT' , 3);

    global $_G;
    $prefix = $_G['config']['db']['1']['tablepre'];

    if( isset( $_GET['page']))
        $page = $_GET['page'];
    else
        $page = 1;
    $page = $page - 1;

    $_status = array(
        ALL         => '全部',
        NOPAYMENT   => '未支付',
        PENDDING    => '处理中',
        RECEIPT     => '发票已开',
        NOCONFIRM   => '待确定',
        CANCEL      => '取消',
    );

    $_user = array(
        SINGLE => '个人用户',
        CORPORATION => '企业用户',
    );

    $_order = array(
        REQUIREMENT => '需求',
        ONLINE      => '线上订单',
        OFFLINE     => '线下订单',
    );

    $_pay = array(
        ONLINE_PAY  => '在线支付',
        OFFLINE_PAY => '线下支付',
    );

    $_receipt = array(
        ALL => '全部',
        ALREADY => '已开发票',
        NOTRECEIPT => '未开发票',
        WAITRECEIPT => '等待开票',
    );

if( isset( $_GET['remove_order'])){
    $id = intval( $_GET['remove_order']);
    DB::query('delete from pre_uclient_desire where id = '.$id);
    exit;
}

if( 'member' === $_GET['operation']){
    if( isset( $_GET['orderby'])){
        $ob = trim( $_GET['orderby']);

        if( ' order by '.$ob.' desc ' === $_SESSION['orderby'])
            $_SESSION['orderby'] = ' order by '.$ob.' ';
        else
            $_SESSION['orderby'] = ' order by '.$ob.' desc ';
    }
    
    $u = DB::fetch_all('select m.uid,m.username,m.email,p.gender,p.realname,p.mobile,p.company,p.position from '.$prefix.'ucenter_members as m left join '.$prefix.'common_member_profile as p on m.uid = p.uid '.$_SESSION['orderby'].' limit '.($page*PAGENUM).','.PAGENUM );
    require template('client/member');
    exit;

}else if( 'order' === $_GET['operation']){

    if( isset( $_POST['add_tmp'])){
            unset( $_POST['add_tmp']);

            $_POST['allowance_date'] = strtotime( trim( $_POST['allowance_date']));

            $_POST['sign_date'] = time();

            $_POST['status'] = 1;

            /*
            $_POST['gender']            = intval( $_POST['gender']);
            $_POST['qq']                    = intval( $_POST['qq']);
            $_POST['productid']     = intval( $_POST['productid']);
            $_POST['productnum']    = intval( $_POST['productnum']);
            $_POST['ordertype']     = intval( $_POST['ordertype']);
            $_POST['usertype']      = intval( $_POST['usertype']);
            $_POST['paymethod']     = intval( $_POST['paymethod']);

            */

            if( 0 ===count( DB::fetch_all('select id from '.$prefix.'uclient_desire where trade_no = \''.$_POST['trade_no'].'\''))){

                $trade = DB::insert( 'uclient_desire' , $_POST );
                if( $trade)
                    echo '<p class="error">新的记录添加成功</p>';
                else 
                    echo '<p class="error">出了小问题</p>';
            }
                
    }else if( isset( $_GET['editorder'])){
            $order_id = intval( $_GET['editorder']);
            $order_content = DB::fetch_first('select * from pre_uclient_desire where id='.$order_id);
            require template('client/new');
            exit;
    }else if( isset( $_POST['fix_tmp'])){
            
            $id = $_POST['id'];
            unset( $_POST['fix_tmp']);
            unset( $_POST['id']);

            $_POST['allowance_date'] = strtotime( trim( $_POST['allowance_date']));
            DB::update('uclient_desire' , $_POST , 'id='.$id);
    }else if( isset( $_GET['view'])){

        $id = intval( $_GET['view']);

        $o = DB::fetch_first('select * from pre_uclient_desire where id = '.$id);

        $feedback = DB::fetch_all('select * from pre_uclient_feedback where order_id = '.$id);

        require template('client/view');
        exit;
    }else if( isset( $_POST['feedback_save'])){

        unset( $_POST['feedback_save']);
        $id = intval( $_POST['order_id']);
        $_POST['date'] = time();
        DB::insert('uclient_feedback' , $_POST);
    }else if( isset( $_GET['remove_fb'])){
        $id = intval( $_GET['remove_fb']);

        echo DB::query('delete from pre_uclient_feedback where id ='.$id);
        exit;
    }

    if( isset( $_GET['new'])){

        $trade_no = strtoupper( date('Ymdhis') . substr( md5( mt_rand(1000,9999)) , 0 , 18));
        require template('client/new');

    }else if( $order_id = $_GET['edit']){


        $order = DB::fetch_first('select * from '.$prefix.'uclient_order where id = '.$order_id);
        $userinfo = DB::fetch_first('select m.uid,m.email,p.gender,p.realname,p.telephone,p.mobile,p.company,p.qq,p.position from '.$prefix.'ucenter_members as m left join '.$prefix.'common_member_profile as p on m.uid = p.uid where m.uid = '.$order['userid']);
        
        require template('client/order_edit');
    }else {

        if( isset( $_GET['page']))
            $page = intval( $_GET['page'])-1;
        else
            $page = 0;
        if( isset( $_POST['order_status']))
            $where = 'status='.intval( $_POST['order_status']);
        else
            $where = '1'; 

        if( isset( $_POST['search_order'])){
            $condition = '\'%'.trim( $_POST['condition']).'%\'';
            $where = 'trade_no like '.$condition.' or '.'phone like '.$condition.' or '.'company like '.$condition.' or '.'realname like '.$condition.' or '.'mobile like '.$condition.' or '.'position like '.$condition.' or '.'email like '.$condition;
        }

        $order = DB::fetch_all('select o.product_id,o.total_price,o.payment,o.date,p.realname from '.$prefix.'uclient_order as o left join '.$prefix.'common_member_profile as p on o.userid  = p.uid  limit '.($page*PAGENUM).','.PAGENUM );

        $allorder = DB::fetch_all('select * from pre_uclient_desire where '.$where.' order by id desc limit '.( $page * PAGENUM).','.PAGENUM);

        require template('client/order_list');
    }
}else if( 'receipt' === $_GET['operation']){

    if( isset( $_GET['edit'])){
        $id = intval( $_GET['edit']);
        $trade = DB::fetch_first('select * from pre_uclient_receipt where id = '.$id);
        $f = 1;
        require template('client/newreceipt');
        exit;
    }

    if( isset( $_GET['new'])){
        require template('client/newreceipt');
        exit;
    }

    if( isset( $_POST['get_by_tradeno'])){
        $trade_no = trim( $_POST['trade_no']);
        $trade = DB::fetch_first('select * from pre_uclient_desire where trade_no = \''.$trade_no.'\'');
        if( empty( $trade))
            $tip = 'Trade_no Not found';
        require template('client/newreceipt');
        exit;
    }

    if( isset( $_POST['confirm'])){

        if( 0 === intval( $_POST['usertype'])){
            $receipt = array(
                'trade_no' => trim( $_POST['trade_no']),
                'status'   => 2,
                'usertype' => 0,
                'realname' => trim( $_POST['realname']),
                'rec_name' => trim( $_POST['rec_name']),
                'rec_content' => trim( $_POST['rec_content']),
                'rec_fee'  => trim( $_POST['rec_fee']),
                'phone'    => trim( $_POST['phone']),
                'address'  => trim( $_POST['address']),
                'etc'      => trim( $_POST['etc'])
            );
        }else if( 1 === intval( $_POST['usertype'])){

            $receipt = array(
                'trade_no' => trim( $_POST['trade_no']),
                'status'   => 2,
                'usertype' => 1,
                'rec_fee'  => trim( $_POST['rec_fee']),
                'rec_type' => intval( $_POST['rec_type']),
                'corp_name' => trim( $_POST['corp_name']),
                'realname' => trim( $_POST['realname2']),
                'address' => trim( $_POST['address2']),
                'bank_name' => trim( $_POST['bank_name']),
                'bank_account' => trim( $_POST['bank_account']),
                'iden_id' => trim( $_POST['iden_id']),
                'etc'     => trim( $_POST['etc']),
            );

        }

        DB::insert( 'uclient_receipt' , $receipt);
        cpmsg('发票数据创建成功', 'admin.php?action=client&operation=receipt', 'succeed');
    }

    if( isset( $_POST['save'])){
        $id = $_POST['id'];
        unset( $_POST['save']);
        unset( $_POST['id']);


        if( 0 === intval( $_POST['usertype'])){
            $receipt = array(
                'status'   => 2,
                'usertype' => 0,
                'realname' => trim( $_POST['realname']),
                'rec_name' => trim( $_POST['rec_name']),
                'rec_content' => trim( $_POST['rec_content']),
                'rec_fee'  => trim( $_POST['rec_fee']),
                'phone'    => trim( $_POST['phone']),
                'address'  => trim( $_POST['address']),
                'etc'      => trim( $_POST['etc'])
            );
        }else if( 1 === intval( $_POST['usertype'])){

            $receipt = array(
                'status'   => 2,
                'usertype' => 1,
                'rec_fee'  => trim( $_POST['rec_fee2']),
                'rec_type' => intval( $_POST['rec_type']),
                'corp_name' => trim( $_POST['corp_name']),
                'realname' => trim( $_POST['realname2']),
                'address' => trim( $_POST['address2']),
                'bank_name' => trim( $_POST['bank_name']),
                'bank_account' => trim( $_POST['bank_account']),
                'iden_id' => trim( $_POST['iden_id']),
                'etc'     => trim( $_POST['etc']),
            );

        }
        DB::update('uclient_receipt', $receipt , 'id='.$id);
    }

    if( isset( $_GET['rm'])){
        $id = intval( $_GET['rm']);
        DB::delete( 'uclient_receipt', array('id'=>$id));
    }

    if( isset( $_GET['page']))
        $page = intval( $_GET['page']) - 1;
    else $page = 0;

    if( isset( $_POST['receipt_status'])){
        switch( intval( $_POST['receipt_status'])){
            case 0 : $where = '1';break;
            case 1 : $where = 'status = 1';break;
            case 2 : $where = 'status = 2';break;
            case 3 : $where = 'status = 3';break;
            default: break;
        }
    }else{
        $where = '1';
    }

    if( isset( $_POST['search_receipt'])){
        $condition = '\'%'.trim( $_POST['condition']).'%\'';
        $where = 'trade_no like '.$condition.' or '.'phone like '.$condition.' or '.'corp_name like '.$condition.' or '.'realname like '.$condition;
    }

    $all_receipt = DB::fetch_all('select * from pre_uclient_receipt where '.$where.' limit '.($page*PAGENUM).','.PAGENUM);
    require template('client/receipt');
    exit;
}else if( 'config' === $_GET['operation']){
    //无需改变
    shownav('client','menu_client_config');
    chmod( DISCUZ_ROOT . 'player.config.php');
    $conf = require( DISCUZ_ROOT . 'player.config.php');
    showformheader('client&operation=config');
    showtableheader('播放器', 'nobottom', '');
    showsetting( '播放器名称' , 'playername' , $conf['playername'], 'text' , false , null , '例如: Kaizhenyun');
    showsetting( '播放器地址', 'fpurl', $conf['fpurl'], 'text' , false, null, '例如: http://www.kicn.cn/jwplayer/player.swf');
    showsetting( '宽度', 'width', $conf['width'], 'text' , false, null, ' 例如:1024');
    showsetting( '高度', 'height', $conf['height'],'text' , false,  null,' 例如:768');
    showsetting( '移动设备视频地址', 'mobileurl', $conf['mobileurl'], 'text' , false, null, '例如: http://oss.aliyuncs.com/mobileyun/');
    showsetting( 'HD视频来源地址', 'videourl', $conf['videourl'], 'text' , false, null, '例如: http://oss.aliyuncs.com/websiteyun/');
    showsetting( 'Controlbar', 'controlbar', $conf['controlbar'], 'text' , false, null, '例如: bottom');
    showsetting( '字幕/Subtitle地址', 'subtitle', $conf['subtitle'], 'text' , false, null, '例如: http://www.kicn.cn/websiteyun/');
    showsetting( 'Stretch', 'stretch', $conf['stretch'], 'text' , false, null, '例如: uniform');
    showsetting( 'Dock', 'dock', $conf['dock'], 'text' , false, null, '例如: true 或者 false');
    showsubmit('update_conf' , '更新配置');
    showtablefooter();
    showformfooter();

    if( submitcheck('update_conf')){
        unset( $_POST['scrolltop']);
        unset( $_POST['scrolltop']);
        unset( $_POST['anchor']);
        unset( $_POST['formhash']);
        unset( $_POST['update_conf']);

        $context = '';
        foreach ($_POST as $key => $value) {
            $context .= '\''.$key .'\'' . '=>' . '\'' .$value . '\'' .',';
        }
        $context = '<?php return array('.$context.');';
        file_put_contents( DISCUZ_ROOT . 'player.config.php', $context);
    }
    //require template('client/configure');
    exit;
}else if( 'cuser' === $_GET['operation']){

    if( isset( $_POST['find'])){
        

        if( empty( $_POST['trade_no']) && empty( $_POST['realname'])){
            require template('client/cuser');
            exit;
        }

        $condition = strlen( trim( $_POST['trade_no'])) ? 'trade_no=\''.trim( $_POST['trade_no']).'\'' : 'realname like \'%'.trim( $_POST['trade_no']).'%\'';
        $rs = DB::fetch_first('select id,usertype,realname,productid,total,blind_uid from pre_uclient_desire where '.$condition);

        if( !count( $rs))
            echo '<p class="error">订单/用户 Not found</p>';

        if( 0 != $rs['blind_uid']){
            $u = DB::fetch_first('select * from pre_uclient_live where uid = '.intval( $rs['blind_uid']));
            $s = DB::fetch_first('select username from pre_ucenter_members where uid = '. intval( $rs['blind_uid']));
        }
    }

    if( isset( $_GET['live'])) {

        $t_id = intval( $_GET['live']);
        $t_user = DB::fetch_first('select * from pre_uclient_desire where id = '.$t_id); 

        $groupselect = array();
        $query = C::t('common_usergroup')->fetch_all_by_not_groupid(array(5, 6, 7));
        foreach($query as $group) {
            $group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
            if($group['type'] == 'member' && $group['creditshigher'] == 0) {
                $groupselect[$group['type']] .= "<option value=\"$group[groupid]\" selected>$group[grouptitle]</option>\n";
            } else {
                $groupselect[$group['type']] .= "<option value=\"$group[groupid]\">$group[grouptitle]</option>\n";
            }
        }
        $groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
            ($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
            ($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
            '<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';
        shownav('client','menu_client_cuser');
        showsubmenu('开通账户');
        showformheader('client&operation=cuser');
        showtableheader();
        showsetting('username', 'newusername', $t_user['realname'].$t_user['id'], 'text');
        showsetting('password', 'newpassword', mt_rand(100000,999999), 'text');
        showsetting('Order_id', 'newid', $t_id, 'text');
        showsetting('Vip', 'newvip', $t_user['productid'], 'text');

        showsetting('email', 'newemail', $t_user['email'], 'text');
        showsetting('usergroup', '', '', '<select name="newgroupid" disabled="disabled">'.$groupselect.'</select>' , 1);
        showsetting('members_add_email_notify', 'emailnotify', '', 'radio');
        showsubmit('addsubmit');
        showtablefooter();
        showformfooter();
        exit;
    }

    if( isset( $_POST['addsubmit'])){

        $newusername = trim($_GET['newusername']);
        $newpassword = trim($_GET['newpassword']);
        $newemail = strtolower(trim($_GET['newemail']));

        if(!$newusername || !isset($_GET['confirmed']) && !$newpassword || !isset($_GET['confirmed']) && !$newemail) {
            cpmsg('members_add_invalid', '', 'error');
        }

        if(C::t('common_member')->fetch_uid_by_username($newusername) || C::t('common_member_archive')->fetch_uid_by_username($newusername)) {
            cpmsg('members_add_username_duplicate', '', 'error');
        }

        loaducenter();

        $uid = uc_user_register(addslashes($newusername), $newpassword, $newemail);
        if($uid <= 0) {
            if($uid == -1) {
                cpmsg('members_add_illegal', '', 'error');
            } elseif($uid == -2) {
                cpmsg('members_username_protect', '', 'error');
            } elseif($uid == -3) {
                if(empty($_GET['confirmed'])) {
                    cpmsg('members_add_username_activation', 'action=members&operation=add&addsubmit=yes&newgroupid='.$_GET['newgroupid'].'&newusername='.rawurlencode($newusername), 'form');
                } else {
                    list($uid,, $newemail) = uc_get_user(addslashes($newusername));
                }
            } elseif($uid == -4) {
                cpmsg('members_email_illegal', '', 'error');
            } elseif($uid == -5) {
                cpmsg('members_email_domain_illegal', '', 'error');
            } elseif($uid == -6) {
                cpmsg('members_email_duplicate', '', 'error');
            }
        }

        $group = C::t('common_usergroup')->fetch($_GET['newgroupid']);
        $newadminid = in_array($group['radminid'], array(1, 2, 3)) ? $group['radminid'] : ($group['type'] == 'special' ? -1 : 0);
        if($group['radminid'] == 1) {
            cpmsg('members_add_admin_none', '', 'error');
        }
        if(in_array($group['groupid'], array(5, 6, 7))) {
            cpmsg('members_add_ban_all_none', '', 'error');
        }

        $profile = $verifyarr = array();
        loadcache('fields_register');
        $init_arr = explode(',', $_G['setting']['initcredits']);
        $password = md5(random(10));
        C::t('common_member')->insert($uid, $newusername, $password, $newemail, 'Manual Acting', $_GET['newgroupid'], $init_arr, $newadminid);
        if($_GET['emailnotify']) {
            if(!function_exists('sendmail')) {
                include libfile('function/mail');
            }
            $add_member_subject = lang('email', 'add_member_subject');
            $add_member_message = lang('email', 'add_member_message', array(
                'newusername' => $newusername,
                'bbname' => $_G['setting']['bbname'],
                'adminusername' => $_G['member']['username'],
                'siteurl' => $_G['siteurl'],
                'newpassword' => $newpassword,
            ));
            if(!sendmail("$newusername <$newemail>", $add_member_subject, $add_member_message)) {
                runlog('sendmail', "$newemail sendmail failed.");
            }
        }

        updatecache('setting');

        $jointime = time();
        $exptime = $jointime + intval( $_GET['newvip'])*M2S;
        $year_pay = intval( $_GET['newvip']) >= 12 ? 1:0;

        DB::query('update pre_uclient_desire set blind_uid = '.$uid. ' where id = '.intval( $_GET['newid']));
        DB::insert('uclient_live' , array('uid' => $uid , 'order_id' => $_GET['newid'] , 'email' => $newemail , 'password' => $newpassword,'live_date' => time()));
        DB::insert('dsu_vip' , array('uid' => $uid , 'jointime' => $jointime , 'exptime' => $exptime , 'year_pay'=> $year_pay , 'level' => 1 , 'czz' => 30 , 'oldgroup'=>1));
        cpmsg('members_add_succeed', '', 'succeed', array('username' => $newusername, 'uid' => $uid));
    }
    require template('client/cuser');
    exit;
}else{
    require template('client/index');
    exit;
}

//include template('client/index');
