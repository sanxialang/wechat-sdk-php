<?php
namespace ezwechat\entity;

class dataInfo{
	public $first = ['value'=>'恭喜你购买成功！', 'color'=>'#173177'];
	public $keyword1 = ['value'=>'巧克力', 'color'=>'#173177'];
	public $keyword2 = ['value'=>'39.8元', 'color'=>'#173177'];
	public $keyword3 = ['value'=>'2014年9月22日', 'color'=>'#173177'];
	public $remark = ['value'=>'欢迎再次购买！', 'color'=>'#173177'];
}

class messageInfo{

    public $touser = '';
    public $template_id = '';
    public $url = '';
    public $miniprogram = ['appid'=>'', 'pagepath'=>''];
    public $data = [
			'first'=>['value'=>'', 'color'=>''],
			'keyword1'=>['value'=>'', 'color'=>''],
			'keyword2'=>['value'=>'', 'color'=>''],
			'keyword3'=>['value'=>'', 'color'=>''],
			'remark'=>['value'=>'', 'color'=>''],
		   ];

    public function __construct($jsonStr = ''){
	$jsonObj = json_decode($jsonStr);
	if(false != $jsonObj){
		$this->touser = $jsonObj->touser;
		$this->template_id = $jsonObj->template_id;
		$this->url = $jsonObj->url;
		$this->miniprogram = $jsonObj->miniprogram;
		$this->data = $jsonObj->data;
	}
    }

    public function __tostring(){
	return json_encode($this);
    }

}
