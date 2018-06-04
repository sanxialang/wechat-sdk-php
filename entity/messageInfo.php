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
    public $miniprogram ;
    public $data ;

    public function __construct(){
	$this->miniprogram = array('appid'=>'', 'pagepath'=>'');
	$this->data = new dataInfo;
    }

    public function __tostring(){
	return json_encode($this);
    }
}
