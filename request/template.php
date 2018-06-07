<?php
namespace ezwechat\request;

require_once 'BaseApi.php';
require_once dirname(__DIR__) . '/entity/messageInfo.php';

/**
 * 模板消息接口
 *
 */
class template extends BaseApi{

    public function __construct($access_token){
        parent::__construct();
        $this->authorizer_access_token = $access_token;
    }

    /**
     * 设置所属行业
     * @description 设置行业可在微信公众平台后台完成，每月可修改行业1次，帐号仅可使用所属行业中相关的模板
     * @param $id1 行业一
     * @param $id2 行业二
     */
    public function api_set_industry($id1, $id2){
        $api = sprintf( $this->api_base_url . 'template/api_set_industry?access_token=%s', $this->getAuthorizer_access_token());
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
     * @description 获取帐号设置的行业信息。可登录微信公众平台，在公众号后台中查看行业信息。
     */
    public function get_industry(){
        $api = sprintf( $this->api_base_url . 'template/get_industry?access_token=%s', $this->getAuthorizer_access_token());

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
     * @description 从行业模板库选择模板到帐号后台，获得模板ID的过程可在微信公众平台后台完成
     */
    public function api_add_template($template_id_short){
        $api = sprintf( $this->api_base_url . 'template/api_add_template?access_token=%s', $this->getAuthorizer_access_token());
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
    public function get_all_private_template(){
        $api = sprintf( $this->api_base_url . 'template/get_all_private_template?access_token=%s', $this->getAuthorizer_access_token());

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
    public function del_private_template($template_id){
        $api = sprintf( $this->api_base_url . 'template/del_private_template?access_token=%s', $this->getAuthorizer_access_token());
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
    public function send(\ezwechat\entity\messageInfo $messageInfo ){
        $api = sprintf( $this->api_base_url . 'message/template/send?access_token=%s', $this->getAuthorizer_access_token());
        $json = $this->api_request_post($api, $messageInfo->__toString() );
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }
}
