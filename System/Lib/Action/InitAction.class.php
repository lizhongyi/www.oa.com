<?php


class InitAction extends Action {
	
	// 生成验证码
    public function verify(){
	    import("ORG.Util.Image");
		Image::buildImageVerify();
    }
}

?>