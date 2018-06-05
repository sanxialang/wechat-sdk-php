<?php
namespace ezwechat\request;

require_once 'BaseApi.php';
require_once dirname(__DIR__) . '/entity/messageInfo.php';

/**
 * 模板消息接口
 *
 */
class template extends BaseApi{

    public function __construct(){
        #$this->__construct();
    }

    /**
     * 设置所属行业
     */
    public function api_set_industry($access_token, $id1, $id2){
	$api = sprintf( $this->api_base_url . 'template/api_set_industry?access_token=%s', $access_token);
        $params = array(
            'industry_id1' =>$id1,
            'industry_id2' =>$id2,
        );
        $json = $this->api_request_post($api, $params);
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;
    }

    /**
     * 获取设置的行业信息
     */
    public function get_industry($access_token){
	$api = sprintf( $this->api_base_url . 'template/get_industry?access_token=%s', $access_token);

        $json = $this->api_request_get($api) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;
    }

    /**
     * 获得模板ID
     */
    public function api_add_template($access_token, $template_id_short){
	$api = sprintf( $this->api_base_url . 'template/api_add_template?access_token=%s', $access_token);
        $params = array(
            'template_id_short' =>$template_id_short,
        );
        $json = $this->api_request_post($api, $params);
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

    /**
     * 获取模板列表
     */
    public function get_all_private_template($access_token){
	$api = sprintf( $this->api_base_url . 'template/get_all_private_template?access_token=%s', $access_token);

        $json = $this->api_request_get($api) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

    /**
     * 删除模板
     */
    public function del_private_template($access_token , $template_id){
        $api = sprintf( $this->api_base_url . 'template/del_private_template?access_token=%s', $access_token);
        $params = array(
            'template_id' =>$template_id,
        );
        $json = $this->api_request_post($api, $params );
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

    /**
     * 发送模板消息
     */
    public function send($access_token , \ezwechat\entity\messageInfo $messageInfo ){
        $api = sprintf( $this->api_base_url . 'message/template/send?access_token=%s', $access_token);
        $json = $this->api_request_post($api, $messageInfo->__toString() );
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }
}
